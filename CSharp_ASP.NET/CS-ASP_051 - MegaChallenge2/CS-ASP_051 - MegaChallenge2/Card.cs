using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace CS_ASP_051___MegaChallenge2
{
    public class Card
    {
        public string Name { get; private set; }
        public int Value { get; private set; }

        public Card()
        {
            this.Name = "Joker";
            this.Value = 0;
        }
        public Card(string name, int value) : this()
        {
            this.Name = name;
            this.Value = value;
        }
    }
}