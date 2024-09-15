<?php
include("./class/frontendClass.php");
include("./config/format.php");

$frontend = new FrontEnd();

if (isset($_GET['song_id'])) {
    $song_id = $_GET['song_id'];
    try {
        $result = $frontend->update_listenCount($song_id);
        if ($result) {
            $response = ['success' => true, 'message' => 'Listen count updated'];
        } else {
            $response = ['success' => false, 'message' => 'Error updating listen count'];
        }
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Song ID is missing'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>