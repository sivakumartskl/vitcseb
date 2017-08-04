<?php

require_once(__DIR__ . '/../../config.php');
require_once (LIB_FOLDER . 'ApiHandler.php');
require_once(__DIR__ . '/../../lib/DBConnection.php');
require_once(LIB_FOLDER . 'ApiException.php');

class Vitcseb {

    public function getAllVitPosts($data) {
        try {
            $dbConnection = new DBConnection();

            $postsSelectQuery = "SELECT vit_user_table.user_name, post_table.post_id, post_table.post, post_table.likes, post_table.dislikes, post_table.comments FROM post_table INNER JOIN vit_user_table ON vit_user_table.user_id=post_table.post_owner_id ORDER BY post_table.post_id DESC;";
            $postsSelectParams = array();

            $result = $dbConnection->getResults($postsSelectQuery, $postsSelectParams);
            if ($result) {
                return $result;
            }
        } catch (Exception $ex) {
            throw ApiException::createFromException($ex, 'There was an problem with database.');
        }
    }

    public function addCommentToComTab($data) {
        try {
            $dbConnection = new DBConnection();

            $commentInsertQuery = "INSERT INTO comments_table(p_id, commented_by_id, comment) VALUES(:pid, :commentedby, :comment)";
            $commentInsertParams = array(':pid' => $data['postid'], ':commentedby' => $data['userid'], ':comment' => $data['comment']);

            $result = $dbConnection->executeQueryLastInsertedId($commentInsertQuery, $commentInsertParams);
            if ($result) {
                $commentsSelectQuery = "SELECT comments FROM post_table WHERE post_id = :pid";
                $commentsSelectParams = array(':pid' => $data['postid']);

                $commres = $dbConnection->getResult($commentsSelectQuery, $commentsSelectParams);
                $commcount = $commres[0]['comments'];
                $ccount = ($commcount + 1);

                $updateCommCount = "UPDATE post_table SET comments = :count WHERE post_id = :poid";
                $updateCommParams = array(':count' => $ccount, ':poid' => $data['postid']);

                $upres = $dbConnection->executeQuery($updateCommCount, $updateCommParams);
                if ($upres) {
                    return $ccount;
                }
            }
        } catch (Exception $ex) {
            throw ApiException::createFromException($ex, 'There was an problem with database.');
        }
    }

    public function showCommsRel($data) {
        try {
            $dbConnection = new DBConnection();

            $commentSelectQuery = "SELECT vit_user_table.user_name, comments_table.comment FROM comments_table INNER JOIN vit_user_table ON vit_user_table.user_id=comments_table.commented_by_id AND comments_table.p_id = :pid ORDER BY comments_table.comment_id;";
            $commentSelectParams = array(':pid' => $data['postid']);

            $result = $dbConnection->getResults($commentSelectQuery, $commentSelectParams);
            if ($result) {
                return $result;
            }
            else {
                return $result = "no";
            }
        } catch (Exception $ex) {
            throw ApiException::createFromException($ex, 'There was an problem with database.');
        }
    }

    public function addLikeForComment($data) {
        try {
            $dbConnection = new DBConnection();

            $likeInsertQuery = "INSERT INTO likes_table(p_id, post_liked_by_id) VALUES(:pid, :likedby)";
            $likeInsertParams = array(':pid' => $data['postid'], ':likedby' => $data['userid']);

            $result = $dbConnection->executeQueryLastInsertedId($likeInsertQuery, $likeInsertParams);
            if ($result) {
                $likesSelectQuery = "SELECT likes FROM post_table WHERE post_id = :pid";
                $likesSelectParams = array(':pid' => $data['postid']);

                $likeres = $dbConnection->getResult($likesSelectQuery, $likesSelectParams);
                $likescount = $likeres[0]['likes'];
                $lcount = ($likescount + 1);

                $updatelikeCount = "UPDATE post_table SET likes = :count WHERE post_id = :poid";
                $updatelikeParams = array(':count' => $lcount, ':poid' => $data['postid']);

                $upres = $dbConnection->executeQuery($updatelikeCount, $updatelikeParams);
                if ($upres) {
                    return $lcount;
                }
            }
        } catch (Exception $ex) {
            throw ApiException::createFromException($ex, 'There was an problem with database.');
        }
    }

    public function addDislikeForComment($data) {
        try {
            $dbConnection = new DBConnection();

            $commentInsertQuery = "INSERT INTO comments_table(p_id, commented_by_id, comment) VALUES(:pid, :commentedby, :comment)";
            $commentInsertParams = array(':pid' => $data['postid'], ':commentedby' => $data['userid'], ':comment' => $data['comment']);

            $result = $dbConnection->executeQueryLastInsertedId($commentInsertQuery, $commentInsertParams);
            if ($result) {
                $commentsSelectQuery = "SELECT comments FROM post_table WHERE post_id = :pid";
                $commentsSelectParams = array(':pid' => $data['postid']);

                $commres = $dbConnection->getResult($commentsSelectQuery, $commentsSelectParams);
                $commcount = $commres[0]['comments'];
                $ccount = ($commcount + 1);

                $updateCommCount = "UPDATE post_table SET comments = :count WHERE post_id = :poid";
                $updateCommParams = array(':count' => $ccount, ':poid' => $data['postid']);

                $upres = $dbConnection->executeQuery($updateCommCount, $updateCommParams);
                if ($upres) {
                    return $ccount;
                }
            }
        } catch (Exception $ex) {
            throw ApiException::createFromException($ex, 'There was an problem with database.');
        }
    }

    public function storeUserPost($data) {
        try {
            $dbConnection = new DBConnection();
            $url = $data['url'];
            $key = explode("=", $url);

            $postInsertQuery = "INSERT INTO post_table(post_owner_id, post, likes, dislikes, comments) VALUES(:ownerid, :post, :likes, :dislikes, :comments)";
            $postInsertParams = array(':ownerid' => $data['userid'], ':post' => $key[1], ':likes' => $data['likes'], ':dislikes' => $data['dislikes'], ':comments' => $data['comments']);

            $result = $dbConnection->executeQueryLastInsertedId($postInsertQuery, $postInsertParams);
            if ($result) {
                $postsSelectQuery = "SELECT vit_user_table.user_name, post_table.post_id, post_table.post, post_table.likes, post_table.dislikes, post_table.comments FROM post_table INNER JOIN vit_user_table ON vit_user_table.user_id=post_table.post_owner_id ORDER BY post_table.post_id DESC;";
                $postsSelectParams = array();

                $resultret = $dbConnection->getResults($postsSelectQuery, $postsSelectParams);
                if ($resultret) {
                    return $resultret;
                }
            }
        } catch (Exception $ex) {
            throw ApiException::createFromException($ex, 'There was an problem with database.');
        }
    }

}
