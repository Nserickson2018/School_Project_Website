# tower of hanoi problem - recursive solution
# tells you what moves to make
# here A is the starting position and C is the ending position.
# B is the temporary position.

stack = [4,3,2,1]
def hanoi(stack,A,B,C):
    global objectNum
    if len(stack) == 1:
        print 'move disc',stack[0],'from',A,'to',C
    else:
        hanoi(stack[1:],A,C,B)
        print 'move disc',stack[0],'from',A,'to',C
        hanoi(stack[1:],B,A,C)
    if stack[0]==1:
        objectNum+=1

#hanoi(stack, 'X','Y','Z')

def stackCounter():
    global objectNum
    objectNum=0
    hanoi(stack, 'X', 'Y', 'Z')
    print "The topmost object is moved ",objectNum," times."

stackCounter()   