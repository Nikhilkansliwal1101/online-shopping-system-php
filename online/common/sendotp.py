#!C:\ProgramData\Anaconda3\python
import smtplib
import random
import sys
# connecting to the server of gmail
# creating a session with smtp server of google
server = smtplib.SMTP('smtp.gmail.com', 587)
# first parameter is adress/loaction  of google's smtp server and second it port number ..for google we use port
# number 22
server.starttls()
# For security reasons,  putting the SMTP connection in the TLS mode. TLS (Transport Layer Security) encrypts all
# the SMTP commands our e-mail id and password
sender="nikhilkansliwal2002@gmail.com"
password="nikhil@1101"
server.login(sender,password)

receiver=sys.argv[1]
otp=random.randint(100000,999999)
print(otp)
subject=sys.argv[2].split('_')
subject=" ".join(subject)
print(subject)
content="Your one time password is : {}".format(otp)
print(content)
try:
    server.sendmail(sender, receiver,"Subject :{} \n\n {}".format(subject, content))  # sending the message
except smtplib.SMTPException as e:
    print(e)

server.close()  # closing the connection