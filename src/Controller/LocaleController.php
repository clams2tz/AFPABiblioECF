<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocaleController extends AbstractController
{ 
    #[Route('/change-locale/{locale}', name: 'change_locale')] 
    public function changeLocale(Request $request, string $locale): Response 
    { 
        $request->getSession()->set('_locale', $locale); 
        return $this->redirect($request->headers->get('referer'));
    }    
}
