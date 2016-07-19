<?php

namespace Wooter\Commands\Payment;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Payment\PaymentMethodNotFound;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Payment\PaymentMethodRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdatePaymentMethodCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $paymentMethodId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $name
     * @param $payment_method_id
     */
    public function __construct($name, $payment_method_id, $user_id)
    {
        $this->name = $name;
        $this->paymentMethodId = $payment_method_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     * @param PaymentMethodRepository $paymentMethodRepository
     * @param UserRepository $userRepository
     * @return
     * @throws PaymentMethodNotFound
     * @throws UserIsNotAdmin
     * @throws UserNotFound
     */
    public function handle(PaymentMethodRepository $paymentMethodRepository, UserRepository $userRepository)
    {
        $paymentMethod = $paymentMethodRepository->getById($this->paymentMethodId);

        if ( ! $paymentMethod)
        {
            throw new PaymentMethodNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user)
        {
            throw new UserNotFound;
        }

        if ( ! $user->isAdmin()) {
            throw new UserIsNotAdmin;
        }

        $paymentMethod->name = $this->name;

        $paymentMethodRepository->create($paymentMethod);

        return $paymentMethod;
    }
}
