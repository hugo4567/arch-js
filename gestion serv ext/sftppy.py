import os, posixpath, argparse, paramiko, stat
 
def ensure_remote_dir(sftp, remote_path):
     dirs = []
     head = remote_path
     while head not in ('', '/'):
         dirs.append(head)
         head = os.path.dirname(head)
     dirs.reverse()
     for d in dirs:
         try:
             sftp.stat(d)
         except IOError:
             sftp.mkdir(d)
 
def upload_dir(sftp, local_dir, remote_dir):
    for root, dirs, files in os.walk(local_dir):
        rel = os.path.relpath(root, local_dir)
        remote_root = remote_dir if rel == '.' else os.path.join(remote_dir, rel).replace('\\','/')
         
        ensure_remote_dir(sftp, remote_root)
        for fname in files:
            local_path = os.path.join(root, fname)
            remote_path = remote_root + '/' + fname
            sftp.put(local_path, remote_path)
 
 # Connexion
host = "l1.dptinfo-usmb.fr"
port = 22
user = "grp1"
# either password or pkey
password = "Exoo2zoa"
pkey_path = None  # e.g. "~/.ssh/id_rsa"

transport = paramiko.Transport((host, port))
if pkey_path:
     key = paramiko.RSAKey.from_private_key_file(os.path.expanduser(pkey_path))
     transport.connect(username=user, pkey=key)
else:
    transport.connect(username=user, password=password)

sftp = paramiko.SFTPClient.from_transport(transport)
try:
    upload_dir(sftp, "/var/www/dev-project", "/home/grp1/public_html")
    print("vrm bon")
finally:
    sftp.close()
    transport.close()

print("C'est bon")
