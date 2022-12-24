<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ville;
use App\Entity\Boutique;
use	Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Categorie;



class AppFixtures extends Fixture
{
    /** @var UserPasswordHasherInterface */
    private	 $hasher;

    /**
     * @param UserPasswordHasherInterface $encoder
     */
    public	function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher =	$hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        //create ville
        $villes=array(
            "76000"=>"ROUEN",
            "76130"=>"MONT SAINT AIGNAN",
            "75000"=>"PARIS",
            "92110"=>"CLICHY",
            "93100"=>"MONTREUIL",
            "77240"=>"CESSON"
        );
        foreach ($villes as $codePostal => $nomVille) {
            $ville = new Ville();
            $ville->setCodePostale($codePostal);
            $ville->setNom($nomVille);
            $manager->persist($ville);
        }

        //create boutiques
        for($i = 1;$i<31;$i++) {

            $boutique = new Boutique();
            $boutique->setNom("boutique".$i);
            $horraires = '[{"lundi":{"matin":"8h-12h","apreMidi":"14h-18h"}},{"mardi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"mercredi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"jeudi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"vendredi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"samedi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"dimanche":{"matin":"8h-12h","apreMidi":"14h-20h"}}]';
            $boutique->setHorairesDeOuverture(
                array(json_encode($horraires))
            );
            if($i % 2 == 0) {
                $boutique->setEnConge(true);
            } else {
                $boutique->setEnConge(false);
            }
            $boutique->setDateDeCreation(new \DateTime());

            $manager->persist($boutique);
        }

        //create users
        $roles = array("ROLE_ADMIN","ROLE_LIVREUR_VENDEUR");
        for($i = 1;$i<11;$i++) {

            $user = new User();
            $user->setNom("nom_utilisateur ".$i);
            $user->setPrenom("prenom_utilisateur ".$i);
            $user->setEmail("email".$i."@gmail.com");

            if($i % 2 == 0) {
                $user->setRoles(["ROLE_ADMIN"]);
            } else {
                $user->setRoles(["ROLE_LIVREUR_VENDEUR"]);
            }
            $hash = $this->hasher->hashPassword($user,"123456mM");
            $user->setPassword($hash);

            $manager->persist($user);

        }
        //Create Categeory
        $categories= array("BOISSONS", "EPICERIE SALEE", "EPICERIE SUCREE", "FRUITS", "LEGUMES", "COSMETIQUES", "VIANDES","BIO", "ANIMALERIE", "PATISSERIES");
        for($i = 0;$i<sizeof($categories);$i++) {
            $category= new Categorie();
            $category->setNom($categories[$i]);
            $manager->persist($category);

        }

        //Create Product
        for($i=1; $i<101;$i++) {
            $produit= new Produit();
            $produit->setNom("Produit".$i);
            $produit->setPrix(2*$i);
            $manager->persist($produit);
        }

        $manager->flush();
    }

}
