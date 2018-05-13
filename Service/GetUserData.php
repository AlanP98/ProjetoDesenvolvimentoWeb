<?php

require_once '../config.php';
require_once DIR . 'Repositorys/PersonRepository.php';
require_once DIR . 'Repositorys/UserRepository.php';
requireLogin();

$auth = Session::getInstance()->getByKey('AUTHENTICATION');
$userId = $auth->getUserId();
$userRepository = new UserRepository();
$userData = $userRepository->getPersonDataByUserId($userId);

echo json_encode($userData);