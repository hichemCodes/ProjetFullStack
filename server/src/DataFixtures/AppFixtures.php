<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
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

        $boutique = new Boutique();
        $boutique->setNom("Tech Store");
        $horraires = '[{"lundi":{"matin":"8h-12h","apreMidi":"14h-18h"}},{"mardi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"mercredi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"jeudi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"vendredi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"samedi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"dimanche":{"matin":"8h-12h","apreMidi":"14h-20h"}}]';
        $boutique->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique->setEnConge(false);
        $boutique->setDateDeCreation(new \DateTime());
        $manager->persist($boutique);

        $boutique1 = new Boutique();
        $boutique1->setNom("Chico Home");
        $boutique1->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique1->setEnConge(false);
        $boutique1->setDateDeCreation(new \DateTime());
        $manager->persist($boutique1);

        $boutique2 = new Boutique();
        $boutique2->setNom("Deco Store");
        $boutique2->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique2->setEnConge(true);
        $boutique2->setDateDeCreation(new \DateTime());
        $manager->persist($boutique2);

        $boutique3 = new Boutique();
        $boutique3->setNom("Sun Store");
        $boutique3->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique3->setEnConge(false);
        $boutique3->setDateDeCreation(new \DateTime());
        $manager->persist($boutique3);

        $boutique4 = new Boutique();
        $boutique4->setNom("Hatch Store");
        $boutique4->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique4->setEnConge(true);
        $boutique4->setDateDeCreation(new \DateTime());
        $manager->persist($boutique4);


        $boutique5 = new Boutique();
        $boutique5->setNom("Fnac ");
        $boutique5->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique5->setEnConge(false);
        $boutique5->setDateDeCreation(new \DateTime());
        $manager->persist($boutique5);


        $boutique6 = new Boutique();
        $boutique6->setNom("Darty ");
        $boutique6->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique6->setEnConge(false);
        $boutique6->setDateDeCreation(new \DateTime());
        $manager->persist($boutique6);


        $boutique7 = new Boutique();
        $boutique7->setNom("Boulanger");
        $boutique7->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique7->setEnConge(true);
        $boutique7->setDateDeCreation(new \DateTime());
        $manager->persist($boutique7);


        $boutique8 = new Boutique();
        $boutique8->setNom("Photo Store");
        $boutique8->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique8->setEnConge(true);
        $boutique8->setDateDeCreation(new \DateTime());
        $manager->persist($boutique8);


        $boutique9 = new Boutique();
        $boutique9->setNom("Mobile");
        $boutique9->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique9->setEnConge(false);
        $boutique9->setDateDeCreation(new \DateTime());
        $manager->persist($boutique9);


        $boutique10 = new Boutique();
        $boutique10->setNom("Cell");
        $boutique10->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique10->setEnConge(false);
        $boutique10->setDateDeCreation(new \DateTime());
        $manager->persist($boutique10);


        $boutique11 = new Boutique();
        $boutique11->setNom("MYStore");
        $boutique11->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique11->setEnConge(true);
        $boutique11->setDateDeCreation(new \DateTime());
        $manager->persist($boutique11);


        $boutique12 = new Boutique();
        $boutique12->setNom("Super Store");
        $boutique12->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique12->setEnConge(false);
        $boutique12->setDateDeCreation(new \DateTime());
        $manager->persist($boutique12);


        $boutique13 = new Boutique();
        $boutique13->setNom("Annaba Technology");
        $boutique13->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique13->setEnConge(false);
        $boutique13->setDateDeCreation(new \DateTime());
        $manager->persist($boutique13);

        $boutique14 = new Boutique();
        $boutique14->setNom("Boutique");
        $boutique14->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique14->setEnConge(false);
        $boutique14->setDateDeCreation(new \DateTime());
        $manager->persist($boutique14);

        $boutique15 = new Boutique();
        $boutique15->setNom("SHOPY");
        $boutique15->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique15->setEnConge(false);
        $boutique15->setDateDeCreation(new \DateTime());
        $manager->persist($boutique15);

        $boutique16 = new Boutique();
        $boutique16->setNom("Robuste Center");
        $boutique16->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique16->setEnConge(false);
        $boutique16->setDateDeCreation(new \DateTime());
        $manager->persist($boutique16);

        $boutique17 = new Boutique();
        $boutique17->setNom("Val Europe");
        $boutique17->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique17->setEnConge(false);
        $boutique17->setDateDeCreation(new \DateTime());
        $manager->persist($boutique17);

        $boutique18 = new Boutique();
        $boutique18->setNom("Disney");
        $boutique18->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique18->setEnConge(false);
        $boutique18->setDateDeCreation(new \DateTime());
        $manager->persist($boutique18);

        $boutique19 = new Boutique();
        $boutique19->setNom("Vapiano France");
        $boutique19->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique19->setEnConge(false);
        $boutique19->setDateDeCreation(new \DateTime());
        $manager->persist($boutique19);

        $boutique20 = new Boutique();
        $boutique20->setNom("Sony France");
        $boutique20->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique20->setEnConge(true);
        $boutique20->setDateDeCreation(new \DateTime());
        $manager->persist($boutique20);

        $boutique21 = new Boutique();
        $boutique21->setNom("Apple France");
        $boutique21->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique21->setEnConge(false);
        $boutique21->setDateDeCreation(new \DateTime());
        $manager->persist($boutique21);

        $boutique22 = new Boutique();
        $boutique22->setNom("Samsung France");
        $boutique22->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique22->setEnConge(true);
        $boutique22->setDateDeCreation(new \DateTime());
        $manager->persist($boutique22);

        $boutique23 = new Boutique();
        $boutique23->setNom("LG France");
        $boutique23->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique23->setEnConge(true);
        $boutique23->setDateDeCreation(new \DateTime());
        $manager->persist($boutique23);

        $boutique24 = new Boutique();
        $boutique24->setNom("Microsoft France");
        $boutique24->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique24->setEnConge(true);
        $boutique24->setDateDeCreation(new \DateTime());
        $manager->persist($boutique24);

        $boutique25 = new Boutique();
        $boutique25->setNom("Kaspersky France");
        $boutique25->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique25->setEnConge(true);
        $boutique25->setDateDeCreation(new \DateTime());
        $manager->persist($boutique25);

        $boutique26 = new Boutique();
        $boutique26->setNom("Asus France");
        $boutique26->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique26->setEnConge(true);
        $boutique26->setDateDeCreation(new \DateTime());
        $manager->persist($boutique26);

        $boutique27 = new Boutique();
        $boutique27->setNom("HP France");
        $boutique27->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique27->setEnConge(true);
        $boutique27->setDateDeCreation(new \DateTime());
        $manager->persist($boutique27);

        $boutique28 = new Boutique();
        $boutique28->setNom("Dell France");
        $boutique28->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique28->setEnConge(true);
        $boutique28->setDateDeCreation(new \DateTime());
        $manager->persist($boutique28);

        $boutique29 = new Boutique();
        $boutique29->setNom("Future France");
        $boutique29->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique29->setEnConge(true);
        $boutique29->setDateDeCreation(new \DateTime());
        $manager->persist($boutique29);

        $boutique30 = new Boutique();
        $boutique30->setNom("Gaming Store");
        $boutique30->setHorairesDeOuverture(
            array(json_encode($horraires))
        );
        $boutique30->setEnConge(true);
        $boutique30->setDateDeCreation(new \DateTime());
        $manager->persist($boutique30);


        //create users
        $roles = array("ROLE_ADMIN","ROLE_LIVREUR_VENDEUR");
        for($i = 1;$i<11;$i++) {

            $user = new User();
            

            if($i % 2 == 0) {
                $user->setRoles(["ROLE_ADMIN"]);
                $user->setNom("nom_admin ".$i);
                $user->setPrenom("prenom_admin ".$i);
                $user->setEmail("email_admin".$i."@gmail.com");
            } else {
                $user->setRoles(["ROLE_LIVREUR_VENDEUR"]);
                $user->setNom("nom_livreur ".$i);
                $user->setPrenom("prenom_livreur ".$i);
                $user->setEmail("email_livreur".$i."@gmail.com");
            }
            $hash = $this->hasher->hashPassword($user,"123456mM");
            $user->setPassword($hash);

            $manager->persist($user);

        }
        //Create Categeory
        $categories= array("INFORMATIQUE", "TABLETTE", "TV", "ELECTROMÉNAGER", "MAISON", "SPORT", "JEUX","DÉCORATION", "SMARTPHONE", "OBJECT CONNÉCTÉ",
            "CAMÉRA");
        /*for($i = 0;$i<sizeof($categories);$i++) {
            $category= new Categorie();
            $category->setNom($categories[$i]);
            $manager->persist($category);

        }*/

        $categorie= new Categorie();
        $categorie->setNom($categories[0]);
        $manager->persist($categorie);

        $categorie1= new Categorie();
        $categorie1->setNom($categories[1]);
        $manager->persist($categorie1);

        $categorie2= new Categorie();
        $categorie2->setNom($categories[2]);
        $manager->persist($categorie2);

        $categorie3= new Categorie();
        $categorie3->setNom($categories[3]);
        $manager->persist($categorie3);

        $categorie4= new Categorie();
        $categorie4->setNom($categories[4]);
        $manager->persist($categorie4);

        $categorie5= new Categorie();
        $categorie5->setNom($categories[5]);
        $manager->persist($categorie5);

        $categorie6= new Categorie();
        $categorie6->setNom($categories[6]);
        $manager->persist($categorie6);

        $categorie7= new Categorie();
        $categorie7->setNom($categories[7]);
        $manager->persist($categorie7);

        $categorie8= new Categorie();
        $categorie8->setNom($categories[8]);
        $manager->persist($categorie8);

        $categorie9= new Categorie();
        $categorie9->setNom("$categories[9]");
        $manager->persist($categorie9);

        $categorie10= new Categorie();
        $categorie10->setNom("$categories[10]");
        $manager->persist($categorie10);

        //Create Product
        //INFORMATIQUE
        $produit= new Produit();
        $produit->setNom("PC Portable Gaming Asus ROG STRIX");
        $produit->setPrix(1699);
        $produit->setDescription("AMD Ryzen 7 16 Go RAM 512 Go SSD Nvidia RTX 3050 Gris");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie);
        $produit->setBoutiqueId($boutique);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("PC Ultra-Portable Asus Zenbook ");
        $produit->setPrix(1499);
        $produit->setDescription("Le PC portable Zenbook OLED EVO UX325 de ASUS est doté d'un design à l'élégance inégalée. Paré d'un châssis de couleur grise.");
        $produit->addCategory($categorie);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setBoutiqueId($boutique26);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("PC portable Asus Zenbook OLED ");
        $produit->setPrix(1299);
        $produit->setDescription("Ecran tactile OLED 15,6'' Full HD Processeur Intel Core™ i7-12700H (14 coeurs, 2,3 GHz / Turbo Boost jusqu'à 4,7 GHz) RAM 16 Go");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie);
        $produit->setBoutiqueId($boutique26);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("PC Ultra-Portable HP Pavilion ");
        $produit->setPrix(899);
        $produit->setDescription("Ecran tactile OLED 15,6'' Full HD Processeur Intel Core™ i7-12700H (14 coeurs, 2,3 GHz / Turbo Boost jusqu'à 4,7 GHz) RAM 16 Go LPDDR5 - 1 To SSD.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie);
        $produit->setBoutiqueId($boutique27);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("PC Portable HP 17 Intel pentium 8 Go RAM 256 Go SSD ");
        $produit->setPrix(429);
        $produit->setDescription("Un ordinateur portable de 17 pouces avec une grande vision de l’avenir. L’ordinateur portable HP 17 est soigneusement conçu et offre des performances avec un processeur AMD .");
        $produit->addCategory($categorie);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setBoutiqueId($boutique);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("PC Portable Gaming Acer Predator Intel Core i7 16 Go RAM 512 Go SSD  ");
        $produit->setPrix(2299);
        $produit->setDescription("Acer Predator Helios PH315-54-72VF : Démarrez les moteurs. Équipez-vous, attachez-vous et laissez Helios ouvrir la voie. Doté d’une technologie de refroidissement de pointe.");
        $produit->addCategory($categorie);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setBoutiqueId($boutique6);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("PC Portable Samsung Galaxy Book2  Intel Core i7 16 Go RAM 512 Go SSD");
        $produit->setPrix(1149);
        $produit->setDescription("Design fin et élégantIntel 12e GenClavier avec pavé numériqueExpérience connectée Galaxy");
        $produit->addCategory($categorie);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("PC Portable Gaming MSI Stealth GS66 Intel Core i9 64 Go RAM 2 To SSD");
        $produit->setPrix(3181);
        $produit->setDescription("Produit ayant déjà servi reconditionné dans son emballage d'origine fourni avec l'ensemble de ses accessoires");
        $produit->addCategory($categorie);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Apple MacBook Air 13");
        $produit->setPrix(1499);
        $produit->setDescription("256 Go SSD 8 Go RAM Puce M2 CPU 8 cœurs GPU 8 cœurs Minuit Nouveau");
        $produit->addCategory($categorie);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("PC Portable Acer Aspire 3");
        $produit->setPrix(679);
        $produit->setDescription("Contour d'écran de plus en plus fin Dalle mate & sans reflet");
        $produit->addCategory($categorie);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //TABLETTE
        $produit= new Produit();
        $produit->setNom("Tablette tactile Samsung Galaxy Tab ");
        $produit->setPrix(499);
        $produit->setDescription("Son design simple et raffiné, avec un bloc photo très fin à l'arrière.");
        $produit->addCategory($categorie1);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Tablette tactile Lenovo Tab P11");
        $produit->setPrix(318);
        $produit->setDescription("11 pouces 128 Go Gris ardoise");
        $produit->addCategory($categorie1);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Tablette tactile Samsung");
        $produit->setPrix(679);
        $produit->setDescription("Un bloc photo très fin à l'arrière.");
        $produit->addCategory($categorie1);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Apple iPad Pro");
        $produit->setPrix(1069);
        $produit->setDescription("iPad Pro : Boosté par la puce M2 Des performances exceptionnelles. Des écrans ultra-sophistiqués. Une connectivité sans fil d’une rapidité extrême.");
        $produit->addCategory($categorie1);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Pack Tablette tactile Huawei Matepad Pro");
        $produit->setPrix(799);
        $produit->setDescription("Découvrez le tout nouveau HarmonyOS 2 sur un grand écran OLED FullView de 12,6 pouces Laissez-vous inspirer par le HUAWEI MatePad Pro.");
        $produit->addCategory($categorie1);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //Without Category
        $produit= new Produit();
        $produit->setNom("Souris sans fil Bluetooth Apple Magic ");
        $produit->setPrix(85);
        $produit->setDescription("Sans fil et rechargeable, la Magic Mouse présente un design optimisé au niveau de sa base, qui lui permet de mieux se déplacer sur votre bureau");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie1);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Souris sans fil silencieuse Logitech");
        $produit->setPrix(18);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Profitez du Silence : Avec le même clic et plus de 90% de réduction du bruit (1) du clic");
        //$produit->setBoutiqueId();
        $produit->addCategory($categorie1);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Clavier Gaming filaire SteelSeries Apex Pro");
        $produit->setPrix(209);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Le prochain bond en avant en matière de claviers mécaniques L’Apex Pro représente le plus grand bond en avant en matière de claviers mécaniques");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Clavier Apple Magic Keyboard avec pavé numérique");
        $produit->setPrix(679);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Le Magic Keyboard avec pavé numérique est un clavier étendu sans fil qui offre des commandes de navigation pour un défilement rapide ");
        //$produit->setBoutiqueId();
        $produit->addCategory($categorie2);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Logitech MK270 Wireless Combo");
        $produit->setPrix(29);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Plug and Play Fiable : Le récepteur USB offre une connexion sans fil fiable ");
        //$produit->setBoutiqueId();
        $produit->addCategory($categorie3);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Extracteur de jus");
        $produit->setPrix(589);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Les plus du produitVitesse de pressage lente de 43 tours/minutes qui permet de conserver le gout et les nutriments");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Presse-agrumes");
        $produit->setPrix(44);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Presse-agrumes. Service au verre, arrêt automatique ");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Friteuse Philips");
        $produit->setPrix(149);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Avec Philips, la friteuse saine n° 1 trouve sa place dans toutes les cuisines. Savourez des aliments sains, croustillants");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Friteuse Philips Essential Airfryer");
        $produit->setPrix(219);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Trouvez des centaines de plats savoureux à cuisiner dans l'Airfryer appairée à l'application NutriU.");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Demo");
        $produit->setPrix(50);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Decodeur pour tout les chaines");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Friteuse sans huile Ninja");
        $produit->setPrix(999);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Faites-en plus avec votre friteuse sans huile grande capacité et ses 2 tiroirs de cuisson indépendants pour cuisiner 2 aliments");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Radiateur mobile");
        $produit->setPrix(199);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("MAZDA vous présente son radiateur mobile à inertie en pierre MIRIDA d'une puissance de 2000 Watts");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Panneau Rayonnant");
        $produit->setPrix(201);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Rayonnant verre LCD - cour aluminium Le rayonnant en verre se démarque grâce à son design hors du commun");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Climatisation Portable ");
        $produit->setPrix(185);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Climatisation Portable S&P METEOR EC 2200W Froid + Chaud");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Convecteur Rowenta");
        $produit->setPrix(119);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Le Vectissimo Black Turbo est muni d'une puissance de 2400 W, qui le place comme l'un des convecteurs les plus efficaces du marché");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Chaudière Granulés");
        $produit->setPrix(6999);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Avantages : Cette chaudière à pellets, avec son coût d'installation faible et les aides à la rénovation énergétique, est une solution de chauffage économique");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Cuisinière à gaz");
        $produit->setPrix(278);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Cuisinière à Gaz HJM GA4200 4200W Noir et une sélection de bonne qualité ");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Soupape de securite");
        $produit->setPrix(25);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Soupape de securite 39109 : Soupapes et clapets pour Chaudiere Deville compatible avec appareils Cb23/60");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Imprimante 3D");
        $produit->setPrix(459);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("L'imprimante 3D offre une technologie de pointe pour un prix ultra contrôlé.");
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Siège gaming Kira");
        $produit->setPrix(169);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setDescription("Ultra confort, conçu pour les longues sessions de jeu");
        //$produit->setBoutiqueId();
        $manager->persist($produit);



        //TV
        $produit= new Produit();
        $produit->setNom("TV OLED LG OLED 139 cm 4K ");
        $produit->setPrix(1299);
        $produit->setDescription("LG OLEDLes téléviseurs LG OLED sont capables d’offrir des images extrêmement détaillées et réalistes grâce aux pixels auto-émissifs");
        $produit->addCategory($categorie2);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setBoutiqueId($boutique12);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("TV LED Philips Ambilight");
        $produit->setPrix(799);
        $produit->setDescription("Un téléviseur fascinantTéléviseur LED 4K UHD Android avec AmbilightUn excellent choix. ");
        $produit->addCategory($categorie2);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("TV Samsung The Frame ");
        $produit->setPrix(599);
        $produit->setDescription("Quand le plus discret des téléviseurs.... devient le plus beau des cadresThe Frame est conçu pour sublimer votre intérieur qu’il soit allumé ou éteint.");
        $produit->addCategory($categorie2);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smart Tech TV LED HD ");
        $produit->setPrix(679);
        $produit->setDescription("La nouvelle série Smart TV Vidaa vous donne accès à toutes les apps les plus populaires. Netflix, Youtube, Molotov TV, Disney +, Prime Video");
        $produit->addCategory($categorie2);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("TV OLED Sony");
        $produit->setPrix(1799);
        $produit->setDescription("L’expérience OLED immersive dans un format compacte et idéale pour le jeu");
        $produit->addCategory($categorie2);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //ELECTROMENAGER
        $produit= new Produit();
        $produit->setNom("DYSON Aspirateur balai");
        $produit->setPrix(749);
        $produit->setDescription("Sol et surfaces (aspirateur à main intégré), Sol, Plafond");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setBoutiqueId($boutique7);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Robot cuiseur Moulinex ");
        $produit->setPrix(1499);
        $produit->setDescription("Avec i-Companion Touch Pro, laissez l'inspiration vous guider ! Utilisez ce robot cuiseur unique pour préparer et cuisiner une grande diversité");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setBoutiqueId($boutique7);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Machine à laver Samsung WW80TA046TH");
        $produit->setPrix(431);
        $produit->setDescription("La technologie ecobubble injecte de l'air au mélange d'eau et de lessive pour une dissolution plus efficace des détergents et la création d'une mousse");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        $produit->setBoutiqueId($boutique7);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Machine À Coudre Bernette");
        $produit->setPrix(349);
        $produit->setDescription("La machine à coudre Bernette Sew & Go 8 rendra plus simple la réalisation de vos projets de couture");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Fer à repasser Calor Ultimate");
        $produit->setPrix(129);
        $produit->setDescription("Ultimate Pure Fer à repasser FV9838C0 Le plus puissant de Calor Stoppe les taches* de calcaire");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Grille pain Moulinex");
        $produit->setPrix(36);
        $produit->setDescription("Avec le grille-pain SOLEIL ivoire, dégustez des tartines grillées à la perfection.");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Machine à thé automatique");
        $produit->setPrix(269);
        $produit->setDescription("Votre thé en Vrac, servis à la tasse, infusé à la perfection.Origin réunit les conditions de réussite de votre thé");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Théière inox Riviera");
        $produit->setPrix(199);
        $produit->setDescription("Utilisable pour tous les thés et infusions, y compris le thé Rooibos");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Théière en verre");
        $produit->setPrix(27);
        $produit->setDescription("Toute en transparence, la théière en verre Megura vous donne à voir le lent et délicat processus d'infusion");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Cheminée bio mural,");
        $produit->setPrix(1119);
        $produit->setDescription("l vous suffit de cette cheminée bio, d'un peu de son combustible liquide naturel et vous aurez rapidement un feu avec de vraies flammes et de la chaleur");
        $produit->addCategory($categorie3);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //MAISON
        $produit= new Produit();
        $produit->setNom("Bureau professionnel ");
        $produit->setPrix(274);
        $produit->setDescription("Bureau avec structure en bois de chêne couleur naturelle et grise, composé de 3 étagères et d'un meuble avec porte");
        $produit->addCategory($categorie4);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Bureau et Armoire Intégrée");
        $produit->setPrix(239);
        $produit->setDescription("Meuble de Bureau avec Armoire Intégrée Coloris Blanc");
        $produit->addCategory($categorie4);
        $produit->setDateDeCreation(new \DateTime());
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Commode moderne");
        $produit->setPrix(164);
        $produit->setDescription("Commode Aster à six tiroirs apportera une touche de modernité et harmonie à votre chambre");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie4);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Lampadaire Lampe à Pied");
        $produit->setPrix(103);
        $produit->setDescription("Cette lampe à pied stylée et moderne embellit votre maison avec son apparence captivante et avec son éclairage effectif.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie4);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Miroir Mural Rond");
        $produit->setPrix(39);
        $produit->setDescription("Matériau: Fabriqué en verre de haute qualité pour une imagerie HD, avec cadre en bois de bamboo");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie4);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //SPORT
        $produit= new Produit();
        $produit->setNom("Banc de Musculation");
        $produit->setPrix(129);
        $produit->setDescription("il est réglable, pliable et inclinable pour un entrainement de Fitness complet !");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Tapis de Course");
        $produit->setPrix(379);
        $produit->setDescription("Notre tapis de course MADRID vous permet de travailler et de développer votre endurance.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Rameur kettler ");
        $produit->setPrix(1299);
        $produit->setDescription("Le rameur Regatta 300 de Kettler à tirage central est équipé d’un double rail en aluminium ultra précis");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Rameur d'appartement Pliable");
        $produit->setPrix(139);
        $produit->setDescription("Rameur d'appartement Fitness, appareil idéal pour le cardio training et la musculation");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Raquette de tennis de table");
        $produit->setPrix(79);
        $produit->setDescription("Raquette de qualité premium de niveau 3000, manche concave.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Raquette de Ping Pong");
        $produit->setPrix(39);
        $produit->setDescription("le manche creux diminue le poids de la raquette et déplace le point d'équilibre vers la palette");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Table de ping-pong pliante");
        $produit->setPrix(165);
        $produit->setDescription("Backspin est un modèle de table de ping-pong simple et fonctionnel qui se caractérise par sa capacité à être pliable");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Billard Américain");
        $produit->setPrix(1399);
        $produit->setDescription("SOKKER a été désignée avec un esprit industriel");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Baby Foot Olympic ");
        $produit->setPrix(1119);
        $produit->setDescription("Avec le Baby Foot Olympic recréez chez vous une ambiance Bistrot ");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Ballon foot");
        $produit->setPrix(20);
        $produit->setDescription("Ballon de la coupe du monde FIFA 2022");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie5);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //JEUX
        $produit= new Produit();
        $produit->setNom("Jeu de cartes ");
        $produit->setPrix(16);
        $produit->setDescription("Dans Skyjo, anticipez, soyez audacieux dans vos décisions et remplacez vos cartes judicieusement");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie6);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Jeu d’échecs ");
        $produit->setPrix(36);
        $produit->setDescription("Retrouvez toutes les sensations d’un jeu d’échecs et de dames, grâce à ces éditions de qualité");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie6);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Monopoly");
        $produit->setPrix(20);
        $produit->setDescription("Le but du jeu consiste à ruiner ses adversaires par des opérations immobilières");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie6);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Scrabble");
        $produit->setPrix(26);
        $produit->setDescription("L'objectif est de cumuler des points, sur la base de tirages aléatoires de lettres");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie6);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("UNO");
        $produit->setPrix(7);
        $produit->setDescription(" Assemblez les cartes par couleur ou par valeur et jouez des cartes");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie6);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //DÉCORATION
        $produit= new Produit();
        $produit->setNom("Sapin artificiel");
        $produit->setPrix(73);
        $produit->setDescription("Sapin artificiel Windy Peak - 150 cm - Vert");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie7);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Horloge murale mécanique");
        $produit->setPrix(169);
        $produit->setDescription("L'horloge pendulaire Thésée est une horloge mécanique en acajou qui possède un mouvement très fiable");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie7);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Porte PHOTO-CUBE ");
        $produit->setPrix(15);
        $produit->setDescription("Splendide porte photo cube en acrylique ! Rangez vos plus belles photos dans ce petit bijou de décoration !");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie7);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Ruban LED lumineuse");
        $produit->setPrix(34);
        $produit->setDescription("Ruban LED 10m RGB Multicolore Bande LED lumineuse avec Télécommande IR 44 touches");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie7);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Guirlande lumineuse LED");
        $produit->setPrix(15);
        $produit->setDescription("Les lumières LED Micro sur fil de cuivre avec 100 LED blanc chaud fournit un éclairage décoratif brillant pour les petits projets.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie7);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //SMARTPHONE
        $produit= new Produit();
        $produit->setNom("iPhone 14 Plus ");
        $produit->setPrix(1196);
        $produit->setDescription("Votre iPhone.Avec iOS 16, vous pouvez personnaliser votre écran verrouillé de façons inédites");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        $produit->setBoutiqueId($boutique21);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Apple iPhone 13 mini");
        $produit->setPrix(1159);
        $produit->setDescription("Notre système photo Pro connaît une évolution plus ambitieuse que jamais, avec un matériel ultra-sophistiqué");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        $produit->setBoutiqueId($boutique21);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("iPhone 14 Pro Max ");
        $produit->setPrix(1479);
        $produit->setDescription("Suivez l’évolution de vos anneaux Activité. Et voyez en direct les informations de vos apps préférées.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        $produit->setBoutiqueId($boutique21);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("iPhone 14 Pro");
        $produit->setPrix(1459);
        $produit->setDescription("L’iPhone 14 Pro est capable de détecter que vous venez d’avoir un grave accident de voiture. Il appelle automatiquement les secours");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId($boutique21);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Apple iPhone 13 Pro Max");
        $produit->setPrix(1379);
        $produit->setDescription("Avec un objectif repensé et un puissant système de mise au point automatique.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId($boutique21);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smartphone Samsung Galaxy S22 Ultra");
        $produit->setPrix(1259);
        $produit->setDescription("Le Samsung Galaxy S22 Ultra est un smartphone d’exception. Avec l’ADN du Galaxy S ");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        $produit->setBoutiqueId($boutique22);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smartphone Samsung Galaxy Z Flip");
        $produit->setPrix(999);
        $produit->setDescription("Design pliable iconique Conception d'exception avec un écran pliable de 6.7 pouces");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smartphone Samsung Galaxy S22");
        $produit->setPrix(699);
        $produit->setDescription("Les bords ultra fins se fondent dans un cadre poli symétrique et viennent harmonieusement entourer l’écran");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smartphone Huawei P30 Lite");
        $produit->setPrix(184);
        $produit->setDescription("Changez les règles de la photographie avec le nouveau P30 Lite de la marque Huawei");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Huawei P30 Pro");
        $produit->setPrix(452);
        $produit->setDescription(" Ce smartphone intègre un appareil photo des plus incomparables : un appareil photo intelligent de 40 Mégapixels");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smartphone Huawei P50");
        $produit->setPrix(724);
        $produit->setDescription("256 Go de ROM, 8 Go de RAM. Design ultracompact, fin et léger. Dual SIM.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smartphone Xiaomi Redmi");
        $produit->setPrix(229);
        $produit->setDescription("Processeur 6nm haute efficacité");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smartphone Oppo Find X5 Pro");
        $produit->setPrix(1299);
        $produit->setDescription("Un appareil photo capturant un milliard de couleurs et bénéfi ciant du savoir-faire uniqueD’Hasselblad");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smartphone Oppo Reno 8 PRO");
        $produit->setPrix(710);
        $produit->setDescription("OS ColorOS 12.1 basé sur Android 12 - 256Go de ROM, 8Go de RAM");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Smartphone Oppo A94");
        $produit->setPrix(362);
        $produit->setDescription("Avec ses fonctionnalités et caractéristiques supérieures, l'OPPO A94 5G propose une expérience de haut vol à un tarif ultra compétitif");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Apple iPhone SE ");
        $produit->setPrix(559);
        $produit->setDescription("L’iPhone SE bénéficie de la même puce surpuissante que l’iPhone 13 : la puce A15 Bionic.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Apple iPhone 11");
        $produit->setPrix(529);
        $produit->setDescription("Ecouteurs EarPods non inclus");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie8);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //OBJECT CONNÉCTÉ
        $produit= new Produit();
        $produit->setNom("Apple Watch Series 8");
        $produit->setPrix(539);
        $produit->setDescription("De puissants capteurs pour davantage de données sur votre forme et votre santé.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie9);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Montre connectée Samsung Galaxy Watch5 Pro");
        $produit->setPrix(469);
        $produit->setDescription("Design élégant & résistant en titane. Intégration de l'écosystème applicatif Google.");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie9);
        $produit->setBoutiqueId($boutique22);
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Montre connectée Samsung Galaxy Watch4");
        $produit->setPrix(199);
        $produit->setDescription("La Galaxy Watch4 Classic, au design intemporel avec son cadran rotatif physique");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie9);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        //Caméra
        $produit= new Produit();
        $produit->setNom("Caméra de Sport étanche");
        $produit->setPrix(199);
        $produit->setDescription("La caméra d'action AKASO Brave 7 vous permet de prendre des photos incroyables et des vidéos ultra HD");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie10);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Caméra stabilisée");
        $produit->setPrix(509);
        $produit->setDescription("DJI Pocket 2 est un petit appareil photo qui vous permet d'enregistrer à lui seul des moments mémorables");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie10);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Drone Double Caméra 4K");
        $produit->setPrix(456);
        $produit->setDescription("Le drone caméra connecté télécommandé vous offre bien des possibilités d'utilisation");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie10);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Drone 4K Parrot");
        $produit->setPrix(992);
        $produit->setDescription("Les démarches à faire avec la nouvelle réglementation: faire une formation gratuite en ligne (puis examen de 40 QCM) et enregistrer son drone");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie10);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Canon EOS 70D - Appareil photo numérique");
        $produit->setPrix(999);
        $produit->setDescription("Saisissez l'instant avec des photos à couper le souffle et des vidéos Full HD grâce au EOS 70D hautes performances");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie10);
        //$produit->setBoutiqueId();
        $manager->persist($produit);

        $produit= new Produit();
        $produit->setNom("Appareil photo reflex Nikon");
        $produit->setPrix(1479);
        $produit->setDescription(" La recherche de l’image parfaite peut vous conduire très loin");
        $produit->setDateDeCreation(new \DateTime());
        $produit->addCategory($categorie10);
        $produit->setBoutiqueId($boutique29);
        $manager->persist($produit);


        $manager->flush();
    }

}
