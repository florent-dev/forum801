<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Section;
use App\Entity\Topic;
use App\Entity\User;
use App\Form\NewTopicType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{
    /**
     * @Route("/getTopic/{id}", name="app_topic_show")
     * @param int $id
     * @return Response
     */
    public function showTopic(int $id)
    {
        $topic = $this->getDoctrine()->getRepository(Topic::class)->find($id);

        return $this->render('topic/topic_view.html.twig', [
            'topic' => $topic,
        ]);
    }

    /**
     * @Route("/newTopic/{sectionId}", name="app_topic_new")
     * @param int $sectionId
     * @return Response
     */
    public function newTopic(int $sectionId)
    {
        $section = $this->getDoctrine()->getRepository(Section::class)->find($sectionId);

        if (!$section) {
            return null;
        }

        $topic = new Topic();
        $topic->setSection($section);

        $form = $this->createForm(NewTopicType::class, $topic);

        return $this->render('topic/topic_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/sendNewTopic", name="app_topic_send_new")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function sendNewTopic(Request $request)
    {
        $topic = new Topic();
        $form = $this->createForm(NewTopicType::class, $topic);

        $form->handleRequest($request);

        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(User::class)->find(1); // TODO : avec un user connecté

        if ($form->isSubmitted() && $form->isValid()) {
            $topic->setAuthor($user);
            $topic->setCreatedAt(new \DateTime());
            $topic->setUpdatedAt(new \DateTime());
            $topic->setPostit(0);
            $topic->setStatus(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            $message = new Message();
            $message->setAuthor($user);
            $message->setContent($form->get('content')->getData());
            $message->setTopic($topic);
            $message->setCreatedAt(new \DateTime());
            $message->setUpdatedAt(new \DateTime());
            $message->setStatus(0);

            $em->persist($message);
            $em->flush();

            return new JsonResponse(['data' => true]);
        }

        return new JsonResponse(['data' => false]);
    }
}
