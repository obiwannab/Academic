# Python Course
# Section 8 - Item #1
#   DRILL: Datetime - Python 2.7
#   Create code that will use the current time of the Portland HQ to find out the time in the
#     NYC & London branches, then compare that time with the branches hours to see if they are
#     open or closed.
#
from datetime import *

class USPacific(tzinfo):
    # US/Pacific Time Zone is UTC -8
    def utcoffset(self, dt):
        return timedelta(hours = -8) + self.dst(dt)
    def tzname(self, dt):
        return "US/Pacific"
    def dst(self, dt):
        # DST starts last Sunday in March
        d = datetime(dt.year, 4, 1)
        self.dston = d - timedelta(days = d.weekday() + 1)
        # DST ends last Sunday in October
        d = datetime(dt.year, 11, 1)
        self.dstoff = d - timedelta(days = d.weekday() + 1)
        if self.dston <= dt.replace(tzinfo = None) < self.dstoff:
            return timedelta(hours = 1)
        else:
            return timedelta(0)

class USEastern(tzinfo):
    # US/Eastern Time Zone is UTC -5
    def utcoffset(self, dt):
        return timedelta(hours = -5) + self.dst(dt)
    def tzname(self, dt):
        return "US/Eastern"
    def dst(self, dt):
        # DST starts last Sunday in March
        d = datetime(dt.year, 4, 1)
        self.dston = d - timedelta(days = d.weekday() + 1)
        # DST ends last Sunday in October
        d = datetime(dt.year, 11, 1)
        self.dstoff = d - timedelta(days = d.weekday() + 1)
        if self.dston <= dt.replace(tzinfo = None) < self.dstoff:
            return timedelta(hours = 1)
        else:
            return timedelta(0)

class UTC(tzinfo):
    # Greenwhich Mean Time, UTC 0
    def utcoffset(self, dt):
        return timedelta(hours = 0) + self.dst(dt)
    def tzname(self, dt):
        return "UTC/Greenwhich Mean Time"
    def dst(self, dt):
        # DST starts last Sunday in March
        d = datetime(dt.year, 4, 1)
        self.dston = d - timedelta(days = d.weekday() + 1)
        # DST ends last Sunday in October
        d = datetime(dt.year, 11, 1)
        self.dstoff = d - timedelta(days = d.weekday() + 1)
        if self.dston <= dt.replace(tzinfo = None) < self.dstoff:
            return timedelta(hours = 1)
        else:
            return timedelta(0)

def show_zone_info(awareObject):  # DEBUG
    print "\tTime Zone: ", awareObject.tzname()
    print "\tDaylight Savings: ", awareObject.dst()
    print "\tUTC Offset: ", awareObject.utcoffset()
    print "\n"

def main():

    pacific = USPacific()
    eastern = USEastern()
    gmt = UTC()

    today = datetime.utcnow()
    now = today.replace(tzinfo = gmt)
    #today = datetime(2015, 10, 15, 9, 30, tzinfo = gmt)  # DEBUG
    portland = today.astimezone(pacific)
    nyc = today.astimezone(eastern)
    london = today.astimezone(gmt)

    print "Today: " + today.strftime("%A %d %B %Y %I:%M%p")
    #show_zone_info(today)  # DEBUG
    print "Portland, OR: " + portland.strftime("%A %d %B %Y %I:%M%p")
    show_zone_info(portland)  # DEBUG
    print "New York, NY: " + nyc.strftime("%A %d %B %Y %I:%M%p")
    show_zone_info(nyc)  # DEBUG
    print "London, UK:   " + london.strftime("%A %d %B %Y %I:%M%p")
    show_zone_info(london)  # DEBUG

if __name__ == "__main__": main()