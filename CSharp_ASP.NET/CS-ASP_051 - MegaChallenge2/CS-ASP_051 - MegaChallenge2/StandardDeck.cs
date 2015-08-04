using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace CS_ASP_051___MegaChallenge2
{
    public class StandardDeck
    {
        public Stack<Card> Deck;
        
        public StandardDeck(bool setup = false)
        {
            this.Deck = new Stack<Card>();
            if (setup) SetupNewDeck();
        }

        private void SetupNewDeck()
        {
            foreach (var suit in new List<string>() { "hearts", "clubs", "diamonds", "spades" })
            {
                foreach (var value in new List<int>() { 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 })
                {
                    if (value == 14) Deck.Push(new Card(String.Format("Ace of {0}", suit), value));
                    else if (value == 13) Deck.Push(new Card(String.Format("King of {0}", suit), value));
                    else if (value == 12) Deck.Push(new Card(String.Format("Queen of {0}", suit), value));
                    else if (value == 11) Deck.Push(new Card(String.Format("Jack of {0}", suit), value));
                    else Deck.Push(new Card(String.Format("{0} of {1}", value, suit), value));
                }
            }
            return;
        }

        public void Shuffle(Random random)
        {
            int deckSize = this.Deck.Count();
            List<Card> deckAsList = new List<Card>();
            //Place Cards into a List
            while (Deck.Count > 0) deckAsList.Add(Deck.Pop());

            //Shuffle...Need to research a better shuffling algorithm to implement...
            int pointer = deckSize;
            while (pointer > 1)
            {
                pointer--;
                int newPosition = random.Next(pointer + 1);
                Card swap = deckAsList[newPosition];
                deckAsList[newPosition] = deckAsList[pointer];
                deckAsList[pointer] = swap;
            }
			
            //Return cards back to the Deck
            for (int i = 0; i < deckAsList.Count(); i++) Deck.Push(deckAsList[i]);
        }
    }
}