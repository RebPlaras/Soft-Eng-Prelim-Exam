<?php  
require_once '../classloader.php';

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
				}

				else {
					$_SESSION['message'] = "An error occured with the query!";
					$_SESSION['status'] = '400';
					header("Location: ../register.php");
				}
			}

			else {
				$_SESSION['message'] = $username . " as username is already taken";
				$_SESSION['status'] = '400';
				header("Location: ../register.php");
			}
		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}
	}
	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
			header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	if (!empty($email) && !empty($password)) {

		if ($userObj->loginUser($email, $password)) {
			header("Location: ../index.php");
		}
		else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../login.php");
	}

}

if (isset($_GET['logoutUserBtn'])) {
	$userObj->logout();
	header("Location: ../index.php");
}



if (isset($_POST['editArticleBtn'])) {
	$title = $_POST['title'];
	$content = $_POST['content'];
	$article_id = $_POST['article_id'];
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

	if ($articleObj->updateArticle($article_id, $title, $content, $image_path)) {
		header("Location: ../articles_from_students.php");
	}
}

if (isset($_POST['deleteArticleBtn'])) {
    $article_id = $_POST['article_id'];
    // Get article details before deleting to get author_id
    $article_details = $articleObj->getArticles($article_id);
    if ($article_details) {
        $author_id = $article_details['author_id'];
        $article_title = $article_details['title'];

        if ($articleObj->deleteArticle($article_id)) {
            // Create notification for the author
            $message = "Your article '" . htmlspecialchars($article_title) . "' has been deleted by an admin.";
            $notificationObj->createNotification($author_id, 'article_deleted', $message, $article_id);
            echo "Article deleted and author notified.";
        } else {
            echo "Failed to delete article.";
        }
    } else {
        echo "Article not found.";
    }
}



if (isset($_POST['requestEditBtn'])) {
    $article_id = $_POST['article_id'];
    $requester_user_id = $_SESSION['user_id']; // Admin's ID
    $message = isset($_POST['edit_request_message']) ? $_POST['edit_request_message'] : 'Please review and edit your article.'; // Assuming a form field for message

    // Fetch article details to get author_id for notification
    $article_details = $articleObj->getArticles($article_id);
    $author_id = $article_details['author_id'];
    $article_title = $article_details['title'];

    if ($articleObj->requestEdit($article_id, $requester_user_id, $message)) {
        // Create notification for the author
        $notification_message = "An admin has requested an edit for your article: '" . htmlspecialchars($article_title) . "'. Message: " . htmlspecialchars($message);
        $notificationObj->createNotification($author_id, 'edit_request', $notification_message, $article_id);

        header("Location: ../articles_from_students.php");
    } else {
        $_SESSION['message'] = "Failed to request edit.";
        $_SESSION['status'] = '400';
        header("Location: ../articles_from_students.php");
    }
}
if (isset($_POST['action']) && $_POST['action'] === 'delete_article') {
    header('Content-Type: application/json');
    $article_id = $_POST['article_id'];
    $article_details = $articleObj->getArticles($article_id);
    if ($article_details) {
        $author_id = $article_details['author_id'];
        $article_title = $article_details['title'];

        if ($articleObj->deleteArticle($article_id)) {
            $message = "Your article '" . htmlspecialchars($article_title) . "' has been deleted by an admin.";
            $notificationObj->createNotification($author_id, 'article_deleted', $message, $article_id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit;
}

if (isset($_POST['updateUserBtn'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $is_admin = $_POST['is_admin'];

    if ($userObj->updateUser($user_id, $username, $email, $is_admin)) {
        header("Location: ../users.php");
    } else {
        // Handle error
        header("Location: ../edit_user.php?id=" . $user_id);
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'delete_user') {
    $user_id = $_POST['user_id'];

    if ($userObj->deleteUser($user_id)) {
        echo 'success';
    } else {
        echo 'error';
    }
    exit;
}