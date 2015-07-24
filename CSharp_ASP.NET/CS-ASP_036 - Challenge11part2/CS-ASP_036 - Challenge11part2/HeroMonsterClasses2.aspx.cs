using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_036___Challenge11part2
{
    public partial class HeroMonsterClasses2 : System.Web.UI.Page
    {
        //Initialize global variables
        string result = "";
        Dice dice = new Dice();

        protected void Page_Load(object sender, EventArgs e)
        {
            //New Characters Join the Battle!!!
            Character hero = new Character();
            hero.Name = "Sir Ronsard";
            hero.Health = 50;
            hero.DamageMaximum = 20;
            hero.AttackBonus = false;
            Character monster = new Character();
            monster.Name = "Goblin Chieftain";
            monster.Health = 35;
            monster.DamageMaximum = 15;
            monster.AttackBonus = true;

            //Check for Bonus Attack
            result += String.Format("{0} engages the {1} in one-to-one combat<br />", hero.Name, monster.Name);
            if (hero.AttackBonus)
            {
                int firstStrikeDamage = hero.Attack(dice);
                monster.Defend(firstStrikeDamage);
                result += String.Format("{0} strikes first with a blow of {1} damage.<br />", hero.Name, firstStrikeDamage);
            }
            if (monster.AttackBonus)
            {
                int firstStrikeDamage = monster.Attack(dice);
                hero.Defend(firstStrikeDamage);
                result += String.Format("The {0} gets the drop on {1} and deals {2} damage.<br />", monster.Name, hero.Name, firstStrikeDamage);
            }
            result += "Let the Battle Begin!<br />";

            //Let the Battle Begin!
            //Reset the Round Counter and combat variables
            int rounds = 1;
            int heroAtk = 0;
            int monsterAtk = 0;
            //Battle Loop
            while (hero.Health > 0 && monster.Health > 0)
            {
                result += String.Format("Round {0}<br /><hr />", rounds);
                //Exchange blows
                heroAtk = hero.Attack(dice);
                monster.Defend(heroAtk);
                result += String.Format("{0} attacks, dealing {1} damage. ", hero.Name, heroAtk);
                monsterAtk = monster.Attack(dice);
                hero.Defend(monsterAtk);
                result += String.Format("{0} retaliates with {1} damage.<br />", monster.Name, monsterAtk);
                //Display results of the round
                displayCharacterStats(hero);
                displayCharacterStats(monster);
                //Next Round
                rounds++;
            }

            //Show the Battle Results
            if (hero.Health <= 0 && monster.Health > 0) result += String.Format("{0} has been defeated by a gloating {1}.", hero.Name, monster.Name);
            else if (hero.Health <= 0 && monster.Health <= 0) result += String.Format("{0} has died on the field of battle, but not before defeating his enemies.", hero.Name);
            else if (hero.Health > 0 && monster.Health <= 0) result += String.Format("The {0} has been defeated by the always victorious {1}!", monster.Name, hero.Name);
            else result += "The outcome of the battle is undecided...";
            resultLabel.Text = result;
        }

        private void displayCharacterStats(Character participant)
        {
            result += String.Format("{0}'s health is at {1}<br />", participant.Name, participant.Health);
            result += String.Format("Maximum Damage: {0}   Attack Bonus: {1}<br />", participant.DamageMaximum, participant.AttackBonus);
            result += "<br />";
        }

    }

    class Dice
    {
        public int Sides { get; set; }
        Random random = new Random();

        public int Roll()
        {
            return random.Next(0, this.Sides);
        }

    }

    class Character
    {
        public string Name { get; set; }
        public int Health { get; set; }
        public int DamageMaximum { get; set; }
        public bool AttackBonus { get; set; }

        public int Attack(Dice dice)
        {
            dice.Sides = this.DamageMaximum;
            return dice.Roll();
        }

        public void Defend(int damage)
        {
            this.Health -= damage;
        }
    }

}