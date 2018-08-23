import socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_address = ('localhost', 1000)
sock.connect(server_address)
sock.send('2')
data = sock.recv(1024)
print(data)
