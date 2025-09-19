<?php  
/**
 * Class for handling Offer-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Offer extends Database {

    public function createOffer($user_id, $description, $proposal_id) {
        $sql = "INSERT INTO offers (user_id, description, proposal_id) VALUES (?, ?, ?)";
        try {
            $this->executeNonQuery($sql, [$user_id, $description, $proposal_id]);
            return true;
        } catch (\PDOException $e) {
            if ($e->getCode() == '23000') { // 23000 is the SQLSTATE for integrity constraint violation
                return "You have already submitted an offer for this proposal.";
            }
            return false;
        }
    }

    private function checkOfferExists($user_id, $proposal_id) {
        $sql = "SELECT COUNT(*) FROM offers WHERE user_id = ? AND proposal_id = ?";
        $result = $this->executeQuerySingle($sql, [$user_id, $proposal_id]);
        return $result['COUNT(*)'] > 0;
    }

    public function getOffers($offer_id = null) {
        if ($offer_id) {
            $sql = "SELECT * FROM offers WHERE offer_id = ?";
            return $this->executeQuerySingle($sql, [$offer_id]);
        }
        $sql = "SELECT 
                    o.*, u.*, p.description AS proposal_description,
                    o.date_added AS offer_date_added
                FROM offers o 
                JOIN fiverr_clone_users u ON o.user_id = u.user_id
                JOIN proposals p ON o.proposal_id = p.proposal_id
                ORDER BY o.date_added DESC";
        return $this->executeQuery($sql);
    }


    public function getOffersByProposalID($proposal_id) {
        $sql = "SELECT 
                    offers.*, fiverr_clone_users.*, 
                    offers.date_added AS offer_date_added 
                FROM offers 
                JOIN fiverr_clone_users ON 
                    offers.user_id = fiverr_clone_users.user_id
                WHERE proposal_id = ? 
                ORDER BY offers.date_added DESC";
        return $this->executeQuery($sql, [$proposal_id]);
    }

    public function updateOffer($description, $offer_id) {
        $sql = "UPDATE offers SET description = ? WHERE offer_id = ?";
        return $this->executeNonQuery($sql, [$description, $offer_id]);
    }
    

    /**
     * Deletes an Offer.
     * @param int $id The Offer ID to delete.
     * @return int The number of affected rows.
     */
    public function deleteOffer($id) {
        $sql = "DELETE FROM offers WHERE offer_id = ?";
        return $this->executeNonQuery($sql, [$id]);
    }
}
?>