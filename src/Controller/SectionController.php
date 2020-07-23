<?php

namespace App\Controller;

use App\Entity\Section;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController
{
    /**
     * @Route("/getAllSections", name="app_section_home")
     */
    public function home()
    {
        $sections = $this->getDoctrine()->getRepository(Section::class)->findAll();

        return $this->render('section/sections_list.html.twig', [
            'sections' => $sections,
        ]);
    }

    /**
     * @Route("/getSection/{id}", name="app_section_show")
     * @param int $id
     * @return Response
     */
    public function showSection(int $id)
    {
        $section = $this->getDoctrine()->getRepository(Section::class)->find($id);

        return $this->render('section/section_view.html.twig', [
            'section' => $section,
        ]);
    }
}
