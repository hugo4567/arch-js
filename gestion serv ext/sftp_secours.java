import com.jcraft.jsch.*;
import java.io.*;
import java.util.*;
import java.nio.file.*;

public class SftpUploader {

    private static final int TOLERANCE = 1;

    public static void ensureRemoteDir(ChannelSftp sftp, String remotePath) throws SftpException {
        String[] folders = remotePath.split("/");
        String path = "";
        for (String folder : folders) {
            if (folder.length() == 0) continue;
            path += "/" + folder;
            try {
                sftp.stat(path);
            } catch (SftpException e) {
                sftp.mkdir(path);
            }
        }
    }

    public static void uploadDir(ChannelSftp sftp, String localDir, String remoteDir) throws IOException, SftpException {
        Files.walk(Paths.get(localDir))
            .filter(Files::isRegularFile)
            .forEach(path -> {
                try {
                    String rel = Paths.get(localDir).relativize(path.getParent()).toString();
                    String remoteRoot = rel.equals(".") ? remoteDir : remoteDir + "/" + rel.replace("\\", "/");
                    ensureRemoteDir(sftp, remoteRoot);

                    String fname = path.getFileName().toString();
                    if (fname.startsWith(".")) return;
                    if (Arrays.asList(".git", ".svn", ".hg", "gestion serv ext", ".vscode").contains(fname)) return;

                    String localPath = path.toString();
                    String remotePath = remoteRoot + "/" + fname;

                    long localSize = Files.size(path);
                    long localMtime = Files.getLastModifiedTime(path).toMillis() / 1000;

                    SftpATTRS attrs = null;
                    long remoteSize = -1, remoteMtime = -1;
                    try {
                        attrs = sftp.stat(remotePath);
                        remoteSize = attrs.getSize();
                        remoteMtime = attrs.getMTime();
                    } catch (SftpException e) {
                        // File does not exist
                    }

                    if (remoteSize != localSize || remoteMtime == -1 || (localMtime - remoteMtime) > TOLERANCE) {
                        sftp.put(localPath, remotePath);
                        System.out.println("Uploaded " + remotePath);
                    } else {
                        System.out.println("Skipped " + remotePath);
                    }
                } catch (Exception e) {
                    System.err.println("Error: " + e.getMessage());
                }
            });
    }

    public static void main(String[] args) {
        String host = "l1.dptinfo-usmb.fr";
        int port = 22;
        String user = "grp1";
        String password = "Exoo2zoa";
        String pkeyPath = null; // e.g. "/home/user/.ssh/id_rsa"

        JSch jsch = new JSch();
        Session session = null;
        ChannelSftp sftp = null;
        try {
            if (pkeyPath != null) {
                jsch.addIdentity(pkeyPath);
                session = jsch.getSession(user, host, port);
            } else {
                session = jsch.getSession(user, host, port);
                session.setPassword(password);
            }
            session.setConfig("StrictHostKeyChecking", "no");
            session.connect();

            Channel channel = session.openChannel("sftp");
            channel.connect();
            sftp = (ChannelSftp) channel;

            uploadDir(sftp, "/var/www/dev-project", "/home/grp1/public_html");
            System.out.println("vrm bon");
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if (sftp != null) sftp.disconnect();
            if (session != null) session.disconnect();
        }
        System.out.println("C'est bon");
    }
}