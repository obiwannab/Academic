using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_035___Challenge10
{
    public partial class PhunWithStrings : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            //1.  Reverse your name
            string name = "Ryan Sauter";
                //Result needs to be: "retuaS nayR"
            string newString = "";
            for (int i = name.Length - 1; i >= 0; i--)
            {
                newString += name[i];
            }
            newString += "<br />";

            //2.  Reverse this sequence:
            string names = "Luke,Leia,Han,Chewbacca";
                //Result needs to be: "Chewbacca,Han,Leia,Luke"
            string[] namesArray = names.Split(',');
            int j = namesArray.Length - 1;
            while (j >= 0)
            {
                newString += namesArray[j] + ",";
                j--;
            }
            newString = newString.Remove(newString.Length - 1, 1);  //Remove the last extra comma inserted by the loop above
            newString += "<br />";

            //3.  Use the sequence to create ASCII art:
                //Result needs to be:
                    // "*****Luke*****"
                    // "*****Leia*****"
                    // "*****Han******"
                    // "**Chewbacca***"
            //MY SOLUTION:
       /*   foreach (string hero in namesArray)
            {
                int fillerTotal = 14 - hero.Length;
                int fillerStart = fillerTotal / 2;
                int fillerEnd = (fillerTotal % 2 == 0) ? fillerStart : fillerStart + 1;
                string temp = "";
                for (int i = 1; i <= fillerStart; i++) temp += "*";
                temp += hero;
                //string temp = hero.PadLeft(fillerStart + hero.Length, '*');
                for (int i = 1; i <= fillerEnd; i++) temp += "*";
                newString += temp + "<br />";
            }
       */   //I like Bob's solution better:
            foreach (string hero in namesArray)
            {
                int padLeft = (14 - hero.Length) / 2;
                string temp = hero.PadLeft(hero.Length + padLeft, '*');
                newString += temp.PadRight(14, '*') + "<br />";
            }
            newString += "<br />";

            //4.  Solve this puzzle:
            string puzzle = "NOW IS ZHEremove-me ZIME FOR ALL GOOD MEN ZO COME ZO ZHE AID OF ZHEIR COUNTRY.";
                //Result should look like this: "Now is the time for all good men to come to the aid of their country."
            //Remove
            int removeIndex = puzzle.IndexOf("remove-me");
            puzzle = puzzle.Remove(removeIndex, 9);
            //Replace
            puzzle = puzzle.Replace('Z', 'T');
            //Lowercase
            puzzle = puzzle.ToLower();
            //Capitalize the first word
            puzzle = puzzle.First().ToString().ToUpper() + puzzle.Substring(1);
                //Bob did two statements: first removed the first character of the string   .Remove(0, 1);
                //     and then inserted the capital N at index 0   .Insert(0, "N");

            newString += puzzle + "<br />";

            resultLabel.Text = newString;
        }
    }
}