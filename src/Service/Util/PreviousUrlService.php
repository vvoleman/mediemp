<?php

namespace App\Service\Util;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PreviousUrlService {

    private const NAME = "_previous_url";

    private SessionInterface $session;

    public function __construct(SessionInterface $session) {
        $this->session = $session;
    }

    /**
     * Sets previous URL from request
     * @param Request $request
     * @return bool
     */
    public function set(Request $request): bool {
        $url = $request->headers->get("referer");

        if (!!$url) {
            $this->session->set(self::NAME, $url);
            return true;
        }

        return false;
    }

    /**
     * Returns previous URL and remove it from session
     * @param bool $clear
     * @return string|null
     */
    public function get(string $default = null, bool $clear = true): ?string {
        $url = $this->session->get(self::NAME);
        if ($clear) $this->session->remove(self::NAME);
        if ($url==null) $url = $default;
        return $url;
    }

    /**
     * Is previous URL set?
     * @return bool
     */
    public function isSet(): bool {
        return $this->session->has(self::NAME);
    }

}