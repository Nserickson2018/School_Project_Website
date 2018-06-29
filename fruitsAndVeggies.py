import sqlite3

dbconnect=sqlite3.connect('fruits_and_veggies.db')

healthydb=dbconnect.cursor()

fruits=open('fruit.txt','r')
veggies=open('vegetables.txt','r')

def CreateTables():
    try:
        healthydb.execute('DROP TABLE IF EXISTS Fruits')
        
        command="CREATE TABLE Fruits(name TEXT PRIMARY KEY,Serving TEXT, Calories INTEGER)"
        healthydb.execute(command)
        
    except:
        pass
    
    try:
        healthydb.execute('DROP TABLE IF EXISTS Veggies')
        
        command="CREATE TABLE Veggies(name TEXT PRIMARY KEY,Serving TEXT,Calories INTEGER)"
        healthydb.execute(command)
    except:
        pass
  
def insertFruits(fruit, serving, calories):
    syntax="INSERT INTO Fruits VALUES('%s','%s',%i)"%(fruit, serving, calories)
    healthydb.execute(syntax)
    dbconnect.commit()
    
def insertVeg(veggie, serving, calories):
    syntax="INSERT INTO Veggies VALUES('%s','%s',%i)"%(veggie, serving, calories)
    healthydb.execute(syntax)
    dbconnect.commit()
    
    
def getData(text):
    name=[]
    serving=[]
    calories=[]
    for line in text:
        #print line
        newline=line.split('|')
        #print newline
        name.append(newline[0])
        serving.append(newline[1])
        calories.append(newline[2])
    #print name
    #print serving
    #print calories
    return name, serving, calories

def insertItems():
    fruitsData=getData(fruits)
    veggieData=getData(veggies)
    fruit=fruitsData[0]
    fserving=fruitsData[1]
    fcalories=fruitsData[2]
    veggie=veggieData[0]
    vserving=veggieData[1]
    vcalories=veggieData[2]
    counter=0
    for item in fruit:
        #item=int(item)
        ftable=insertFruits(item,fserving[counter],int(fcalories[counter]))
        counter+=1
    counterV=0
    for item in veggie:
        vtable=insertVeg(item,vserving[counterV],int(vcalories[counterV]))
        counterV+=1
    
def findData(table):
    syntax="SELECT name,Serving,Calories FROM "+table
    healthydb.execute(syntax)
    for row in healthydb:
        print 'Name: '+row[0]+',  Servings: '+row[1]+',  Calories: '+str(row[2])


        
CreateTables()
       
#print getData(fruits)
#print '\n'
#print getData(veggies)
insertItems()
#findData('Fruits')
#print "\n"
#findData('Veggies')

def whatVeggie():
    vegName=raw_input("What vegetable would you like to search for?: ")
    #vegName=vegName[0].upper
    syntax="SELECT name,Calories FROM Veggies"
    healthydb.execute(syntax)
    count=0
    for row in healthydb:
        #print row
        if row[0]==vegName:
            print "Calorie Content for "+vegName+" is "+str(row[1])
            count+=1
        else:
            pass
    if count==0:
        print "Sorry! I don't know this vegetable. Your are on your own with this alleged vegetable."
        
def whatFruit():
    fruitName=raw_input("What fruit would you like to search for?: ")
    syntax="SELECT name,Calories FROM Fruits"
    healthydb.execute(syntax)
    count=0
    for row in healthydb:
        #print row
        if row[0]==fruitName:
            print "Calorie Content for "+fruitName+" is "+str(row[1])
            count+=1
        else:
            pass
    if count==0:
        print "Sorry! I don't know this fruit. Your are on your own with this alleged fruit."

whatVeggie()        
whatFruit()

healthydb.close()