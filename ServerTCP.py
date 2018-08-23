import socket
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
servr_add = ('localhost', 1000)
s.bind(servr_add)
s.listen(10)
print ("waiting on connection")
while 1:
    clientsock, addr = s.accept()
    print ('connected from:', addr)
    data1 = clientsock.recv(1024)
    res = int(data1)
    clientsock.send(str(res*res))
clientsock.close()
serversock.close()
    
    
