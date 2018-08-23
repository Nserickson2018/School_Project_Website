import socket
s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
servr_add = ('localhost', 8000)
s.bind(servr_add)
while 1:
    print('waiting')
    data1, addr= s.recvfrom(1024)
    data1.upper()
    s.sendto(data1, addr)
s.close()

