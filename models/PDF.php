<?php

namespace app\models;

use app\core\Application;
use app\core\Functions;
use app\lib\FPDF;

class PDF extends FPDF
{
    public function _construct()
    {
    }

    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 6);
        $this->SetTextColor(200);
        $this->Cell(0, 9, 'Character created using retroDUD.eu!', 0, 0, 'R');
    }

    public static function create(Character $character, string $path = '/'): string
    {

        $imagick = new \Imagick();
        $pdf = new PDF();

        $pdf->AddPage();
        $pdf->Image(Application::$ROOT_DIR . '/lib/CharacterSheet.jpg', 0, 0, 210, 297);

        //Set Name
        $pdf->SetFont('Arial', '', 16);

        $pdf->SetXY(15, 25);
        $pdf->Cell(70, 4, $character->getName());

        //Set Base info
        $pdf->SetFont('', '', 12);

        $pdf->SetXY(91, 19);
        $pdf->Cell(70, 4, $character->getClass() . " 1");
        $pdf->SetXY(128, 19);
        $pdf->Cell(70, 4, $character->getBackground());
        if (!Application::isGuest()) {
            $pdf->SetXY(168, 19);
            $pdf->Cell(70, 4, $character->getUser());
        }
        //$pdf->Cell(70, 4, htmlspecialchars($_SESSION["username"]));

        $pdf->SetXY(91, 29);
        $pdf->Cell(70, 4, $character->getRace());
        $pdf->SetXY(128, 29);
        $pdf->Cell(70, 4, $character->getAlignment());
        $pdf->SetXY(168, 29);
        $pdf->Cell(70, 4, '0');

        //Set Attributes
        $pdf->SetFont('', '', 16);
        $pdf->SetXY(12, 62);
        $pdf->Cell(15, 4, $character->getAttributes()['strength'], 0, 0, 'C');
        $pdf->SetXY(12, 89);
        $pdf->Cell(15, 4, $character->getAttributes()['dexterity'], 0, 0, 'C');
        $pdf->SetXY(12, 116);
        $pdf->Cell(15, 4, $character->getAttributes()['constitution'], 0, 0, 'C');
        $pdf->SetXY(12, 143);
        $pdf->Cell(15, 4, $character->getAttributes()['intelligence'], 0, 0, 'C');
        $pdf->SetXY(12, 170);
        $pdf->Cell(15, 4, $character->getAttributes()['wisdom'], 0, 0, 'C');
        $pdf->SetXY(12, 197);
        $pdf->Cell(15, 4, $character->getAttributes()['charisma'], 0, 0, 'C');

        //Set Perception and other proficiencies and Languages
        $pdf->SetFont('', '', 10);
        $pdf->SetXY(7, 222);
        $pdf->Cell(15, 4, $character->getSkills()['perception'], 0, 0, 'C');

        $pdf->SetXY(10, 235);
        $pdf->Multicell(56, 4, Functions::arrayToString($character->getProficienciesAndLanguages()), 0, 1);

        //Set Inspiration, proficiency bonus, Saving Throws and Skills
        $pdf->SetFont('', '', 8);
        $pdf->SetXY(30, 50);
        $pdf->Cell(15, 4, '0', 0, 0, 'C');
        $pdf->SetXY(30, 64);
        $pdf->Cell(15, 4, $character->getProficiency(), 0, 0, 'C');

        $pdf->SetXY(33, 77);
        $pdf->Cell(15, 4, $character->getSavingThrows()['strength'], 0, 0, 'C');
        $pdf->SetXY(33, 82);
        $pdf->Cell(15, 4, $character->getSavingThrows()['dexterity'], 0, 0, 'C');
        $pdf->SetXY(33, 87);
        $pdf->Cell(15, 4, $character->getSavingThrows()['constitution'], 0, 0, 'C');
        $pdf->SetXY(33, 92);
        $pdf->Cell(15, 4, $character->getSavingThrows()['intelligence'], 0, 0, 'C');
        $pdf->SetXY(33, 97);
        $pdf->Cell(15, 4, $character->getSavingThrows()['wisdom'], 0, 0, 'C');
        $pdf->SetXY(33, 102);
        $pdf->Cell(15, 4, $character->getSavingThrows()['charisma'], 0, 0, 'C');

        $pdf->SetXY(33, 120);
        $pdf->Cell(15, 4, $character->getSkills()['acrobatics'], 0, 0, 'C');
        $pdf->SetXY(33, 125);
        $pdf->Cell(15, 4, $character->getSkills()['animalHandling'], 0, 0, 'C');
        $pdf->SetXY(33, 130);
        $pdf->Cell(15, 4, $character->getSkills()['arcana'], 0, 0, 'C');
        $pdf->SetXY(33, 135);
        $pdf->Cell(15, 4, $character->getSkills()['athletics'], 0, 0, 'C');
        $pdf->SetXY(33, 140);
        $pdf->Cell(15, 4, $character->getSkills()['deception'], 0, 0, 'C');
        $pdf->SetXY(33, 145);
        $pdf->Cell(15, 4, $character->getSkills()['history'], 0, 0, 'C');
        $pdf->SetXY(33, 150);
        $pdf->Cell(15, 4, $character->getSkills()['insight'], 0, 0, 'C');
        $pdf->SetXY(33, 155);
        $pdf->Cell(15, 4, $character->getSkills()['intimidation'], 0, 0, 'C');
        $pdf->SetXY(33, 160);
        $pdf->Cell(15, 4, $character->getSkills()['investigation'], 0, 0, 'C');
        $pdf->SetXY(33, 165);
        $pdf->Cell(15, 4, $character->getSkills()['medicine'], 0, 0, 'C');
        $pdf->SetXY(33, 170);
        $pdf->Cell(15, 4, $character->getSkills()['nature'], 0, 0, 'C');
        $pdf->SetXY(33, 175);
        $pdf->Cell(15, 4, $character->getSkills()['perception'], 0, 0, 'C');
        $pdf->SetXY(33, 180);
        $pdf->Cell(15, 4, $character->getSkills()['performance'], 0, 0, 'C');
        $pdf->SetXY(33, 185);
        $pdf->Cell(15, 4, $character->getSkills()['persuasion'], 0, 0, 'C');
        $pdf->SetXY(33, 190);
        $pdf->Cell(15, 4, $character->getSkills()['religion'], 0, 0, 'C');
        $pdf->SetXY(33, 195);
        $pdf->Cell(15, 4, $character->getSkills()['sleightOfHand'], 0, 0, 'C');
        $pdf->SetXY(33, 200);
        $pdf->Cell(15, 4, $character->getSkills()['stealth'], 0, 0, 'C');
        $pdf->SetXY(33, 205);
        $pdf->Cell(15, 4, $character->getSkills()['survival'], 0, 0, 'C');

        //Set Armor, initiative, speed, HP, HitDice, attacks and equipment
        $pdf->SetFont('', '', 14);
        $pdf->SetXY(78, 56);
        $pdf->Cell(15, 4, $character->getArmor(), 0, 0, 'C');
        $pdf->SetXY(97, 56);
        $pdf->Cell(15, 4, $character->getInitiative(), 0, 0, 'C');
        $pdf->SetXY(117, 56);
        $pdf->Cell(15, 4, $character->getSpeed(), 0, 0, 'C');

        $pdf->SetFont('', '', 10);
        $pdf->SetXY(99, 73);
        $pdf->Cell(15, 4, $character->getCurrentHitPoints());

        $pdf->SetFont('', '', 14);
        $pdf->SetXY(86, 126);
        $pdf->Cell(15, 4, $character->getHitDice(), 0, 0, 'C');

        $pdf->SetFont('', '', 10);

        //Multiple attack in 8u increments
        $tmpY = 148;
        for ($i = 0; $i < 3; $i++) {
            if ($character->getAttacks()[$i]) {
                $pdf->SetXY(76, $tmpY);
                $pdf->Cell(15, 4, $character->getAttacks()[$i]->getAttackName());
                $pdf->SetXY(100, $tmpY);
                $pdf->Cell(15, 4, $character->getAttacks()[$i]->getBonus());
                $pdf->SetXY(112, $tmpY);
                $pdf->Cell(15, 4, $character->getAttacks()[$i]->getComment());
                $tmpY++;
            } else {
                break;
            }
        }
        $tmpY = null;
        unset($tmpY);

        $pdf->SetFont('', '', 14);
        $pdf->SetXY(76, 226);
        $pdf->Cell(15, 4, $character->getMoney()['CP'], 0, 0, 'C');
        $pdf->SetXY(76, 236);
        $pdf->Cell(15, 4, $character->getMoney()['SP'], 0, 0, 'C');
        $pdf->SetXY(76, 246);
        $pdf->Cell(15, 4, $character->getMoney()['EP'], 0, 0, 'C');
        $pdf->SetXY(76, 255);
        $pdf->Cell(15, 4, $character->getMoney()['GP'], 0, 0, 'C');
        $pdf->SetXY(76, 226);
        $pdf->Cell(15, 4, $character->getMoney()['CP'], 0, 0, 'C');
        $pdf->SetXY(76, 236);
        $pdf->Cell(15, 4, $character->getMoney()['SP'], 0, 0, 'C');
        $pdf->SetXY(76, 246);
        $pdf->Cell(15, 4, $character->getMoney()['EP'], 0, 0, 'C');
        $pdf->SetXY(76, 255);
        $pdf->Cell(15, 4, $character->getMoney()['GP'], 0, 0, 'C');
        $pdf->SetXY(76, 265);
        $pdf->Cell(15, 4, $character->getMoney()['PP'], 0, 0, 'C');

        $pdf->SetFont('', '', 8);
        $pdf->SetXY(92, 223);
        $pdf->Multicell(48, 4, $character->printEquipment());

        //Set Personality traits, ideals, bonds, flaws and features
        $pdf->SetFont('', '', 10);
        $pdf->SetXY(143, 52);
        $pdf->Multicell(54, 4, $character->getPersonalityTraits());
        $pdf->SetXY(143, 78);
        $pdf->Multicell(54, 4, $character->getIdeals());
        $pdf->SetXY(143, 98);
        $pdf->Multicell(54, 4, $character->getBonds());
        $pdf->SetXY(143, 119);
        $pdf->Multicell(54, 4, $character->getFlaws());
        $pdf->SetXY(141, 144);
        $pdf->Multicell(56, 4, $character->printFeatures());

        $pdf->Output('F', Application::$ROOT_DIR . $path . substr($character->getFile(), 0, -4) . ".pdf");
        $imagick->readImage(Application::$ROOT_DIR . $path . substr($character->getFile(), 0, -4) . ".pdf");
        $imagick->writeImages(Application::$ROOT_DIR . $path . substr($character->getFile(), 0, -4) . ".jpg", false);

        return Application::$ROOT_DIR . $path . substr($character->getFile(), 0, -4) . ".pdf";
    }
}
