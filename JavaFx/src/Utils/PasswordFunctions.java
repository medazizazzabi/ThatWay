/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Utils;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

/**
 *
 * @author Aziza
 */
public class PasswordFunctions {
    private static final String ALGORITHM = "SHA-256";

  public static String hashPassword(String password) {
    try {
      MessageDigest md = MessageDigest.getInstance(ALGORITHM);
      byte[] hashedPassword = md.digest(password.getBytes());
      StringBuilder sb = new StringBuilder();
      for (byte b : hashedPassword) {
        sb.append(String.format("%02x", b));
      }
      return sb.toString();
    } catch (NoSuchAlgorithmException e) {
      throw new RuntimeException("Failed to hash password.", e);
    }
  }
  
  public static boolean verifyPassword(String password, String hashedPassword) {
    try {
      MessageDigest md = MessageDigest.getInstance(ALGORITHM);
      byte[] hashedInput = md.digest(password.getBytes());
      StringBuilder sb = new StringBuilder();
      for (byte b : hashedInput) {
        sb.append(String.format("%02x", b));
      }
      String hashedInputString = sb.toString();
      return hashedInputString.equals(hashedPassword);
    } catch (NoSuchAlgorithmException e) {
      throw new RuntimeException("Failed to verify password.", e);
    }
  }
}
