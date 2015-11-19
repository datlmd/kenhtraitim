<html>
    <head>

    </head>
    <body>
        <?php
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        require_once '../vendor/autoload.php';

        use Guzzle\Http\Client;
        
        $pageId = 4314218152227506519;
        $secretKey = "SHOT0uNhRUVb8UUXk8MH";
        $toUid = 1138536247984117487;
        $message = "Test PHP SDK";
        $pathPhoto = "/home/huytn/Downloads/heart.jpg";
        $pathVoice = "/home/huytn/Downloads/voice.amr";
        $timeStamp = system('date +%s%N');
        $temp = $pageId . $toUid . $message . $timeStamp . $secretKey;
        
        $mac = hash('sha256', $temp);

        $client = new Client('http://dev.openapi.zaloapp.com/page/message');

        $params = array(
            "act" => "text",
            "pageid" => $pageId,
            "touid" => $toUid,
            "message" => $message,
            "timestamp" => $timeStamp,
            "version" => "1",
            "mac" => $mac,
        );
        $client->setDefaultOption('query', $params);
        $params = $client->getDefaultOption('query');
        
        $request = $client->get();
        $response = $request->send()->json();
        
        echo $response;
        ?>
    </body>
</html>