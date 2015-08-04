using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace CS_ASP_045___Challenge12
{
    public class Player
    {
        public string Name { get; set; }
        public int CurrentScore { get; set; }

        public Player()
        {
            this.Name = "";
            this.CurrentScore = 0;
        }

        public Player(string name) : this()
        {
            this.Name = name;
        }
    }
}