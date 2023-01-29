<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



final class SellerProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $persistProcessor,
    private readonly UserPasswordHasherInterface $passwordHasher){

    }
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []){
        if (!$data->getMotDePasse()) {
            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }
        $password = $this->passwordHasher->hashPassword($data, $data->getMotDePasse());
        $data->setPassword($password);
        return $this->persistProcessor->process($data,$operation, $uriVariables, $context);
    }
}

