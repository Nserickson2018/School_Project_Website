import socket
sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
server_address = ('localhost', 8000)
textmsge=raw_input('please enter a message ')
sent = sock.sendto(textmsge, server_address)
text, addr = sock.recvfrom(1024)
print(text)
