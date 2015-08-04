using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Darts;

namespace CS_ASP_045___Challenge12
{
    public class Score
    {
        public static int CalculateDartScore(Dart dart)
        {
        int score = 0;
        //Is it a bullseye?
        if (dart.ThrowResult == 0) { return score = (dart.InnerRing) ? 50 : 25; }
        //If not, then is it in an Inner or Outer Ring?
        if (dart.InnerRing) { return score = dart.ThrowResult * 3; }
        else if (dart.OuterRing) { return score = dart.ThrowResult * 2; }
        else { return score = dart.ThrowResult; }
        }
    }
}