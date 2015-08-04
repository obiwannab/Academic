using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace CS_ASP_051___MegaChallenge2
{
    public static class Battle
    {
        public static string StartBattle(Player player1, Player player2)
        {
            string battleResult = "";
            bool warStatus = false;
            do
            {
                //make sure each player has enough cards to battle
                if (player1.Hand.Deck.Count() == 0 || player2.Hand.Deck.Count() == 0)
                {
                    string playerRanOut = (player1.Hand.Deck.Count() == 0) ? player1.Name : player2.Name;
                    battleResult += String.Format("The war is over...{0} is out of cards.", playerRanOut);
                    return battleResult;
                }
                //each player draws a card
                player1.DiscardPile.Push(player1.Hand.Deck.Pop());
                player2.DiscardPile.Push(player2.Hand.Deck.Pop());
                battleResult += String.Format("{0}'s {1} vs. {2}'s {3}<br />",
                                              player1.Name, player1.DiscardPile.Peek().Name,
                                              player2.Name, player2.DiscardPile.Peek().Name);
                //cards are compared for battle: higher value wins the trick; if equal start a war
                if (player1.DiscardPile.Peek().Value > player2.DiscardPile.Peek().Value)
                {
                    battleResult += CollectBattleWinnings(player1, player2);
                    warStatus = false;
                }
                else if (player1.DiscardPile.Peek().Value < player2.DiscardPile.Peek().Value)
                {
                    battleResult += CollectBattleWinnings(player2, player1);
                    warStatus = false;
                }
                else
                {
                    battleResult += "***************WAR***************<br />Each player draws three cards face down...Next Battle resolves the war...<br />&nbsp;&nbsp;";
                    warStatus = StartWar(player1, player2);
                }
            } while (warStatus);  //End Do-While Loop: If there is no war, do not repeat...
            return battleResult;
        }

        private static string CollectBattleWinnings(Player winner, Player loser)
        {
            string winResult = String.Format("{0} wins this round...and collects a total of {1} cards:<br />", 
                                winner.Name, (winner.DiscardPile.Count() + loser.DiscardPile.Count()).ToString());
            //winResult += DisplayBattleWinnings(winner, loser);  //DECISION: need to decide if I want to display the winnings or not...variant rules...
            while (winner.DiscardPile.Count() > 0) winner.Winnings.Push(winner.DiscardPile.Pop());
            while (loser.DiscardPile.Count() > 0) winner.Winnings.Push(loser.DiscardPile.Pop());
            return winResult;
        }

        private static bool StartWar(Player player1, Player player2)
        {
            bool warStatus = true;
            //each player draws three more cards
            for (int i = 1; i <= 3; i++)
            {
                //determine if each player has enough cards for a war
                if (player1.Hand.Deck.Count() == 0 || player2.Hand.Deck.Count() == 0) return warStatus;
                player1.DiscardPile.Push(player1.Hand.Deck.Pop());
                player2.DiscardPile.Push(player2.Hand.Deck.Pop());
            }
            return warStatus;
        }

    }
}