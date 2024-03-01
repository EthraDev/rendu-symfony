<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PokemonController extends AbstractController
{
    #[Route('/pokemon', name: 'app_pokemon')]
    public function index(EntityManagerInterface $em, Request $r, SluggerInterface $slugger): Response
    {

        $un_pokemon = new Pokemon();
        $form = $this->createForm(PokemonType::class, $un_pokemon);
        $form->handleRequest($r);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($un_pokemon->getPokemonName()) . '-' . uniqid();
            $un_pokemon->setSlug($slug);
            $em->persist($un_pokemon);
            $em->flush();
        }

        $pokemons = $em->getRepository(Pokemon::class)->findAll();

        return $this->render('pokemon/index.html.twig', [
            'pokemons' => $pokemons,
            'add' => $form->createView()
        ]);
    }

    #[Route('/pokemon/delete/{id}', name: 'app_pokemon_delete')]
    public function delete(Request $r ,EntityManagerInterface $em, Pokemon $pokemon)
    {
        if($this->isCsrfTokenValid('delete'.$pokemon->getId(), $r->request->get('csrf'))){
            $em->remove($pokemon);
            $em->flush();
        }

        return $this->redirectToRoute('app_pokemon');
    }

    #[Route('/pokemon/{slug}', name: 'app_pokemon_show')]
    public function show(Pokemon $pokemon)
    {
        return $this->render('pokemon/show.html.twig', [
            'pokemon' => $pokemon
        ]);
    }

    #[Route('/pokemon/edit/{slug}', name: 'app_pokemon_edit')]
    public function edit(Pokemon $pokemon, Request $r, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $form = $this->createForm(PokemonType::class, $pokemon);
        $form->handleRequest($r);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($pokemon->getPokemonName()) . '-' . uniqid();
            $pokemon->setSlug($slug);
            $em->persist($pokemon);
            $em->flush();
            return $this->redirectToRoute('app_pokemon');
        }

        return $this->render('pokemon/edit.html.twig', [
            'edit' => $form->createView()
        ]);
    }
}
