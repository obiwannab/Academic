# Python Course
# Section 8 - Item #1
#   DRILL: Datetime - Python 2.7
#   Create code that will use the current time of the Portland HQ to find out the time in the
#     NYC & London branches, then compare that time with the branches hours to see if they are
#     open or closed.
#
import datetime

def main():

    today = datetime.datetime.now()
    #today = datetime.datetime(2015, 6, 24, 17, 30, 0)  # DEBUG: local time is 5:30PM
    #today = datetime.datetime(2015, 6, 24, 21, 30, 0)  # DEBUG: local time is 9:30PM
    #today = datetime.datetime(2015, 6, 24, 4, 30, 0)  # DEBUG: local time is 4:30AM
    #today = datetime.datetime(2015, 6, 24, 8, 30, 0)  # DEBUG: local time is 8:30PM
    now = today.time()
    localHour = today.hour

    # Calculate the local time in New York, NY
    if localHour < 21:
        nycTime = now.replace(hour = localHour + 3)
    else:
        nycTime = now.replace(hour = localHour + 3 - 24)

    # Calculate the local time in London, England
    if localHour < 15:
        londonTime = now.replace(hour = localHour + 8)
    else:
        londonTime = now.replace(hour = localHour + 8 - 24)

    startTime = datetime.time(9)
    endTime = datetime.time(21)

    print "Portland, OR: " + now.strftime("%I:%M%p") + " Pacific Standard Time"
    print "New York, NY: " + nycTime.strftime("%I:%M%p") + " Eastern Standard Time"
    if nycTime < startTime or nycTime >= endTime:
        print "\tThe New York branch is currently closed."
    print "London, UK:   " + londonTime.strftime("%I:%M%p") + " UTC/Greenwhich Mean Time"
    if londonTime < startTime or londonTime >= endTime:
        print "\tThe London branch is currently closed."

if __name__ == "__main__": main()
