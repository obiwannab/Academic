using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace CS_ASP_051___MegaChallenge2
{
    public class Player
    {
        public string Name { get; set; }
        public StandardDeck Hand { get; set; }
        public Stack<Card> DiscardPile { get; set; }
        public Stack<Card> Winnings { get; set; }

        public Player()
        {
            this.Name = "";
            this.Hand = new StandardDeck();
            this.DiscardPile = new Stack<Card>();
            this.Winnings = new Stack<Card>();
        }
        public Player(string name) : this()
        {
            this.Name = name;
        }
    }
}