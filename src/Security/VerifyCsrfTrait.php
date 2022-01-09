<?php

namespace App\Security;

use App\Service\PreviousUrlService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Translation\TranslatableMessage;

trait VerifyCsrfTrait {
    use LoggerAwareTrait;
    private CsrfTokenManagerInterface $csrfManager;
    private FlashBagInterface $flash;

    /**
     * Checks if token is valid
     * @param string $id
     * @param string $value
     * @return bool
     */
    public function verify(string $id, string $value): bool {
        $token = new CsrfToken($id,$value);
        if(!$this->csrfManager->isTokenValid($token)){
            $this->flash->add("error",new TranslatableMessage("security.csrf.invalid"));
            $this->getLogger()->error(sprintf("Invalid CSRF token used for id:'%s'",$id),[
                "csrf" => $token
            ]);
            return false;
        }
        return true;
    }

    /**
     * @required
     */
    public function setServices(CsrfTokenManagerInterface $csrfManager,FlashBagInterface $flash) {
        $this->csrfManager = $csrfManager;
        $this->flash = $flash;
    }


}