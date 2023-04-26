/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package UI.UserManagement.SignUp;

import DB.UserCRUD;
import Utils.PasswordFunctions;
import Utils.SendMail;
import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javax.mail.MessagingException;
import javax.mail.Multipart;
import javax.mail.internet.MimeBodyPart;
import javax.mail.internet.MimeMessage;
import javax.mail.internet.MimeMultipart;
import Entities.User;
import javafx.embed.swing.SwingFXUtils;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.paint.Color;
import javafx.scene.web.WebView;
import javafx.stage.Stage;
import nl.captcha.Captcha;

/**
 * FXML Controller class
 *
 * @author Aziza
 */
public class SignUpController implements Initializable {

    @FXML
    private Button signupBtn;
    @FXML
    private TextField firstName;
    @FXML
    private TextField phone;
    @FXML
    private TextField email;
    @FXML
    private PasswordField password;
    @FXML
    private PasswordField password2;
    @FXML
    private TextField lastName;
    @FXML
    private TextField address;
    @FXML
    private Label error;
    @FXML
    private TextField cin;

    /**
     * Initializes the controller class.
     */
    @FXML
    private ImageView Imagecaptcha;

    private Captcha captchaobject;
    @FXML
    private TextField captcharesponse;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        this.loadCpatcha();
    }

    @FXML
    private void sign(ActionEvent event) {
        if (validForm()) {
            User new_user = new User();
            new_user.setFirst_name(firstName.getText());
            new_user.setLast_name(lastName.getText());
            new_user.setEmail(email.getText());
            new_user.setPassword(PasswordFunctions.hashPassword(password.getText()));
            new_user.setPhone(Integer.parseInt(phone.getText()));
            new_user.setCin(Integer.parseInt(cin.getText()));
            new_user.setAddress(address.getText());
            new_user.setAdmin(false);
            UserCRUD usercrud = new UserCRUD();
            usercrud.addEntity(new_user);
            User.setCurrent_user(usercrud.getUserByEmail(email.getText()));
            this.sendmail(email.getText(), lastName.getText() + " " + firstName.getText());
            Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
            alert.setTitle("Account Created");
            alert.setContentText("Your account was created successfully and an email was sent to you");
            alert.showAndWait();
            Parent root = null;
            try {
                root = FXMLLoader.load(getClass().getResource("../../MainDashboard/Dashboard.fxml"));
            } catch (IOException ex) {
            }

            Scene scene = new Scene(root);
            scene.setFill(Color.TRANSPARENT);
            Stage stage = new Stage();
            stage.setScene(scene);
            stage.show();
            signupBtn.getScene().getWindow().hide();
        }
    }

    private boolean validForm() {
        String errorText = "";
        if (firstName.getText().isEmpty() || lastName.getText().isEmpty() || email.getText().isEmpty()
                || password.getText().isEmpty() || password2.getText().isEmpty() || phone.getText().isEmpty()
                || cin.getText().isEmpty() || address.getText().isEmpty()) {
            error.setText("Please fill all fields\n");
            return false;
        }
        // check valid email
        if (!email.getText().matches("^[A-Za-z0-9+_.-]+@(.+)$")) {
            errorText += "Invalid email\n";
        }
        if (!password.getText().equals(password2.getText())) {
            errorText += "Passwords don't match\n";
        }
        // check valid phone
        if (!phone.getText().matches("^[0-9]{8}$")) {
            errorText += ("Invalid phone number\n");
        }
        // check valid cin
        if (!cin.getText().matches("^[0-9]{8}$")) {
            errorText += ("Invalid CIN\n");
        }
        if (!captchaobject.isCorrect(captcharesponse.getText())) {
            errorText += ("Invalid Cpatcha\n");
        }

        if (errorText.length() > 0) {
            error.setText(errorText);
            this.loadCpatcha();
            return false;
        }
        return true;
    }

    private void sendmail(String mail, String name) {
        Thread mailThread = new Thread(() -> {
            try {
                SendMail mailObject = new SendMail(mail);
                MimeMessage message = mailObject.getMessage();
                // Set Subject: header field
                message.setSubject("Welcome to That Way!");

                // Read the HTML content from a file
                String fileName = "C:\\Users\\Aziza\\Desktop\\Studying\\PIDEV\\ThatWay\\JavaFx\\src\\Assests\\templates\\mail\\mail.html"; // replace with your file name
                BufferedReader reader = new BufferedReader(new FileReader(fileName));
                StringBuilder stringBuilder = new StringBuilder();
                String line;
                while ((line = reader.readLine()) != null) {
                    stringBuilder.append(line);
                }
                reader.close();
                String htmlContent = stringBuilder.toString();

                // Replace placeholders in the HTML content with actual values
                htmlContent = htmlContent.replace("{username}", name);

                // Create a message part to represent the html content
                MimeBodyPart messageBodyPart = new MimeBodyPart();
                messageBodyPart.setContent(htmlContent, "text/html");

                // Create a multipart message to include the message body part
                Multipart multipart = new MimeMultipart();
                multipart.addBodyPart(messageBodyPart);

                // Set the content of the message to be the multipart message
                message.setContent(multipart);

                mailObject.setMessage(message);
                mailObject.send();

            } catch (MessagingException ex) {
                Logger.getLogger(SignUpController.class.getName()).log(Level.SEVERE, null, ex);
            } catch (FileNotFoundException ex) {
                Logger.getLogger(SignUpController.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IOException ex) {
                Logger.getLogger(SignUpController.class.getName()).log(Level.SEVERE, null, ex);
            }
        });

        mailThread.start();
    }

    private void loadCpatcha() {
        captchaobject = new Captcha.Builder(271, 90)
                .addText()
                .addBackground()
                .addNoise()
                .gimp()
                .addBorder()
                .build();
        Image image = SwingFXUtils.toFXImage(captchaobject.getImage(), null);
        Imagecaptcha.setImage(image);
    }

}
