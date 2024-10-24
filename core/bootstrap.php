<?php namespace GamingPassion;

    use GamingPassion\Factories\CommentFactory;
    use GamingPassion\Factories\PostFactory;
    use GamingPassion\Factories\RatingFactory;
    use GamingPassion\Factories\UserFactory;
    use GamingPassion\Services\CommentService;
    use GamingPassion\Services\MessageService;
    use GamingPassion\Services\PostService;
    use GamingPassion\Services\RatingService;
    use GamingPassion\Services\UserService;

    require __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../credentials.php';

    $mysqlClient = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if(!$mysqlClient)
    {
        die('Could not connect to database.');
    }

	$databaseInstance = new Database($mysqlClient);
    $connection = $databaseInstance->connection;
    
    session_start();

	require_once 'Services/general-functions.php';
	require_once 'Services/users-functions.php';
	require_once 'Services/error-functions.php';

    if(UserService::isLoggedIn())
    {
        $userFactory = new UserFactory($databaseInstance);
        $user = $userFactory->getUserByUsername($_SESSION['username']);
    }

    $postService = new PostService(new PostFactory($databaseInstance));
    $ratingService = new RatingService(new RatingFactory($databaseInstance));
    $commentService = new CommentService(new CommentFactory($databaseInstance));
    $messageService = new MessageService();
?>