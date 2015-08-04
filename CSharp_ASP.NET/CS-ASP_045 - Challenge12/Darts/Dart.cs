using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Darts
{
    public class Dart
    {
        private Random _randomNum;
        public int ThrowResult { get; private set; }
        public bool InnerRing { get; private set; }
        public bool OuterRing { get; private set; }

        public Dart(Random randomNum)
        {
            this._randomNum = randomNum;
            this.ThrowResult = 0;
            this.InnerRing = false;
            this.OuterRing = false;
        }

        public void ThrowDart()
        {
            this.ThrowResult = _randomNum.Next(0, 21);
            setFlags();
            //return this.ThrowResult;
        }

        private void setFlags()
        {
            this.InnerRing = (this._randomNum.Next(1, 21) == 20) ? true : false;
            this.OuterRing = (this._randomNum.Next(1, 21) == 20) ? true : false;
        }
    }
}
