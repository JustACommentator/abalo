<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require '/Users/bendemartin/Documents/GitHub/abalo/vendor/autoload.php';

class PromotionWebsocket implements MessageComponentInterface
{
    protected SplObjectStorage $clients;
    protected array $promotionId;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->promotionId = [];
    }

    function onOpen(ConnectionInterface $conn)
    {
        echo "Connection opened\n";
        $this->clients->attach($conn);
    }

    function onClose(ConnectionInterface $conn)
    {
        echo "Connection closed\n";
        $this->clients->detach($conn);
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo $e;
        $conn->close();
    }


    function onMessage(ConnectionInterface $from, $msg)
    {
        $msg = collect(json_decode($msg));

        if ($type = $msg->get('type')) {
            if ($type === 'add_to_promotion') {
                $articleId = $msg->get('id');
                $articleName = $msg->get('name');

                $this->promotionId = ['id' => $articleId, 'name' => trim($articleName)];

                /** @var ConnectionInterface $client */
                foreach ($this->clients as $client) {
                    $client->send(json_encode(['id' => $articleId, 'name' => trim($articleName)]));
                }
            } else {
                if ($this->promotionId) {
                    $from->send(json_encode($this->promotionId));
                }
            }
        }
    }
}


$app = new Ratchet\App('localhost', 8080);
$app->route('/chat', new PromotionWebsocket, array('*'));
$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));

echo "Starting WebSocketServer\n";
$app->run();
