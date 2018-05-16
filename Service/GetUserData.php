<?php

require_once '../config.php';
require_once DIR . 'Repositorys/PersonRepository.php';
require_once DIR . 'Repositorys/UserRepository.php';
requireLogin();

$auth = Session::getInstance()->getByKey('AUTHENTICATION');
$idUser = $auth->getIdUser();
$userRepository = new UserRepository();
$userData = $userRepository->getPersonDataByIdUser($idUser);

echo json_encode($userData);