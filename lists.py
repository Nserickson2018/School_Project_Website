#this program takes a arguments 2 lists, provided by the user, and divides each
#element in the first by the corresponding element in the second. Uses try and 
#except method
list1=input('Enter a list of intergers: ')
list2=input('Enter a second list of intergers that is the same length: ')
def divLists(list1,list2):
    keyList=[]
    try:
        if len(list1)==len(list2):
            #print list1,list2
            pass
        else:
            raise Exception('\nThe lists are not equal in length')
        
        alphabet='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
        for item in list1:
            if str(item) not in alphabet:
                pass
            else:
                raise Exception('\nList cannot contain letters')
        for item in list2:
            if str(item) not in alphabet:
                pass
            else:
                raise Exception('\nList cannot conatain letters')
            
        if 0 not in list2:
            pass
        else:
            raise Exception('\nSecond list cannot conatain zero. Cannot divide by zero.')
        
        if type(list1)==type(keyList) and type(list2)==type(keyList):
            pass
        else:
            raise Exception('\nInput must be a list')
        
        
    except Exception as e:
        return e        
      
    else:
        divList=[]
        for i in range(len(list1)):
            divNum=float(list1[i])/float(list2[i])
            #print list1[i],'divided by',list2[i],'is equal to',divNum
            divList.append(divNum)
            #print divList
        return divList
        
    
print divLists(list1,list2)