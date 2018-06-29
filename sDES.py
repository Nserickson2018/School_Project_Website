import urllib
import json

def getReview():
    moviereview="http://api.nytimes.com/svc/movies/v2/reviews/search.json?"
    outfile=open("output.txt","w")
    
    while True:
        movie=raw_input("Enter a movie name: ")
        outfile.write('Movie Searched: '+movie+'\n')
        if len(movie)<1:break
        #moviename="'"+movie+"'"
        #print moviename
        url=moviereview+urllib.urlencode({'query':movie, 'offset':'20', 'api-key':'83e6a00c07a318f98824dec045526d48:14:73583577'})
        print url
        print "Retreiving", url
        uh=urllib.urlopen(url)
        data=uh.read()
        print "Retreived", len(data), "characters"
        
        try:
            js=json.loads(str(data))
        except:
            js=None
        if js['num_results']==0:
            print "===No Results==="
            outfile.write('===No Results===\n')
            break
        elif js['num_results']<20:
            url=moviereview+urllib.urlencode({'query':movie, 'api-key':'83e6a00c07a318f98824dec045526d48:14:73583577'})
            data=urllib.urlopen(url).read()
        if 'status' not in js or js['status']!='OK':
            print "===Failure to Retreive==="
            print data
            continue
        
        print json.dumps(js, indent=4)
        
        title=js["results"][0]["display_title"]
        date=js["results"][0]["opening_date"]
        headline=js["results"][0]["headline"]
        awards=js["results"][0]["related_urls"][2]
        rating=js["results"][0]["mpaa_rating"]
        #print "Movie Title:",title
        #print "Release Date:",date
        #print "Headline:",headline
        #print "Links to Awards that the movie won:",awards
        #print "MPAA Rating:",rating
        
        outfile.write("Movie Title: "+title+"\n")
        outfile.write("Release Date: "+date+"\n")
        outfile.write("Headline: "+headline+"\n")
        outfile.write("Links to awards the movie won: "+str(awards)+"\n")
        outfile.write("MPAA Rating: "+str(rating)+"\n")
        
    outfile.close()

getReview()        