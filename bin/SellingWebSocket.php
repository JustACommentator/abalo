<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require '/Users/bendemartin/Documents/GitHub/abalo/vendor/autoload.php';

class SellingWebSocket implements MessageComponentInterface
{

    protected SplObjectStorage $clients;
    protected \Illuminate\Support\Collection $users;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->users = collect();
    }

    public function onOpen(ConnectionInterface $conn) {
        echo "Connection opened\n";
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $conn, $msg) {
        $sub = collect(json_decode($msg));

        if($type = $sub->get('type')){
            if($type === 'register_user' && ! $this->users->has($sub->get('user_id'))){
                    $this->users->put($sub->get('user_id'), $conn);

            }
            else if($type === 'sold_article'){
                /** @var ConnectionInterface $conn */
                $conn = $this->users->get(trim($sub->get('user_id')));

                if($conn){
                    $msg = $sub->get('message');
                    $conn->send($msg);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

$app = new Ratchet\App('localhost', 8090);
$app->route('/chat', new SellingWebSocket, array('*'));
$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));

echo "Starting WebSocketServer\n";
$app->run();
