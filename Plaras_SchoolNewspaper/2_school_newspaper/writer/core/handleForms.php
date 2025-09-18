<?php  
require_once '../classloader.php';

// --- USER HANDLERS ---
if (isset($_POST['insertNewUserBtn'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password == $confirm_password) {
            if (!$userObj->usernameExists($username)) {
                if ($userObj->registerUser($username, $email, $password)) {
                    header("Location: ../login.php");
                    exit;
                } else {
                    $_SESSION['message'] = "An error occurred with the query!";
                    $_SESSION['status'] = '400';
                }
            } else {
                $_SESSION['message'] = $username . " as username is already taken";
                $_SESSION['status'] = '400';
            }
        } else {
            $_SESSION['message'] = "Please make sure both passwords are equal";
            $_SESSION['status'] = '400';
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
    }
    header("Location: ../register.php");
    exit;
}

if (isset($_POST['loginUserBtn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        if ($userObj->loginUser($email, $password)) {
            $_SESSION['user_role'] = $_SESSION['is_admin'] ? 'admin' : 'writer';
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['message'] = "Username/password invalid";
            $_SESSION['status'] = "400";
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
    }
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['logoutUserBtn'])) {
    $userObj->logout();
    header("Location: ../index.php");
    exit;
}

// --- ARTICLE HANDLERS ---
if (isset($_POST['insertArticleBtn'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $author_id = $_SESSION['user_id'];
    $image_path = null;

    if (isset($_FILES['articleImage']) && $_FILES['articleImage']['error'] == 0) {
        $target_dir = "../../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_name = uniqid() . "_" . basename($_FILES['articleImage']['name']);
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($_FILES['articleImage']['tmp_name'], $target_file)) {
            $image_path = $image_name;
        }
    }

    if ($articleObj->createArticle($title, $description, $author_id, $category_id, $image_path)) {
        header("Location: ../articles_submitted.php");
        exit;
    }
}

if (isset($_POST['editArticleBtn'])) {
    $title = $_POST['title'];
    $content = $_POST['content']; 
    $article_id = $_POST['article_id'];
    $category_id = $_POST['category_id'];
    $current_image_path = $_POST['current_image_path'];
    $image_path = $current_image_path;

    if (isset($_FILES['articleImage']) && $_FILES['articleImage']['error'] == 0) {
        $target_dir = "../../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_name = uniqid() . "_" . basename($_FILES['articleImage']['name']);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES['articleImage']['tmp_name'], $target_file)) {
            $image_path = $image_name;
        }
    }

    if ($articleObj->updateArticle($article_id, $title, $content, $category_id, $image_path)) {
        header("Location: ../articles_submitted.php");
        exit;
    } else {
        $_SESSION['message'] = "Article update failed.";
        $_SESSION['status'] = '400';
        header("Location: ../articles_submitted.php");
        exit;
    }
}

if (isset($_POST['deleteArticleBtn'])) {
    $article_id = $_POST['article_id'];
    echo $articleObj->deleteArticle($article_id);
    exit;
}

// --- EDIT REQUEST HANDLERS ---
if (isset($_POST['action']) && $_POST['action'] === 'request_edit_from_author') {
    $article_id = $_POST['article_id'];
    $requester_user_id = $_SESSION['user_id'];
    $message = "A writer has requested to edit your article.";

    $article_details = $articleObj->getArticles($article_id);
    $author_id = $article_details['author_id'];
    $article_title = $article_details['title'];

    if ($articleObj->requestEdit($article_id, $requester_user_id, $message)) {
        $notification_message = "Writer " . htmlspecialchars($userObj->getUsernameById($requester_user_id)) . 
            " has requested to edit your article: '" . htmlspecialchars($article_title) . "'.";
        $notificationObj->createNotification($author_id, 'edit_request_from_writer', $notification_message, $article_id);
        $_SESSION['message'] = "Edit request sent to author.";
        $_SESSION['status'] = '200';
    } else {
        $_SESSION['message'] = "Failed to send edit request.";
        $_SESSION['status'] = '400';
    }
    header("Location: ../all_articles.php");
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'accept_edit_request') {
    $article_id = $_POST['article_id'];
    $article_details = $articleObj->getArticles($article_id);
    if ($article_details) {
        $requester_user_id = $article_details['edit_requested_by_user_id'];
        $article_title = $article_details['title'];

        if ($articleObj->acceptEditRequest($article_id)) {
            $articleObj->shareArticle($article_id, $requester_user_id);
            $message = "Your edit request for '" . htmlspecialchars($article_title) . "' has been accepted by the author.";
            $notificationObj->createNotification($requester_user_id, 'edit_request_accepted', $message, $article_id);
            $_SESSION['message'] = "Edit request accepted.";
            $_SESSION['status'] = '200';
        } else {
            $_SESSION['message'] = "Failed to accept edit request.";
            $_SESSION['status'] = '400';
        }
    }
    header("Location: ../all_articles.php");
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'reject_edit_request') {
    $article_id = $_POST['article_id'];
    $article_details = $articleObj->getArticles($article_id);
    if ($article_details) {
        $requester_user_id = $article_details['edit_requested_by_user_id'];
        $article_title = $article_details['title'];

        if ($articleObj->rejectEditRequest($article_id)) {
            $message = "Your edit request for '" . htmlspecialchars($article_title) . "' has been rejected by the author.";
            $notificationObj->createNotification($requester_user_id, 'edit_request_rejected', $message, $article_id);
            $_SESSION['message'] = "Edit request rejected.";
            $_SESSION['status'] = '400';
        } else {
            $_SESSION['message'] = "Failed to reject edit request.";
            $_SESSION['status'] = '400';
        }
    }
    header("Location: ../all_articles.php");
    exit;
}
