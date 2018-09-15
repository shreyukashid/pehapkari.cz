<?php declare(strict_types=1);

namespace OpenTraining\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class SecurityController
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * @var EngineInterface
     */
    private $templatingEngine;

    public function __construct(AuthenticationUtils $authenticationUtils, EngineInterface $templatingEngine)
    {
        $this->authenticationUtils = $authenticationUtils;
        $this->templatingEngine = $templatingEngine;
    }

    /**
     * @Route("/login/", name="security_login")
     */
    public function loginAction(): Response
    {
        return $this->templatingEngine->renderResponse('security/login.html.twig', [
            // last username entered by the user
            'last_username' => $this->authenticationUtils->getLastUsername(),
            // last user if there was some
            'error' => $this->authenticationUtils->getLastAuthenticationError(),
        ]);
    }
}
