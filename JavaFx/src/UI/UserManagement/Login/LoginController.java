/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package UI.UserManagement.Login;

import java.net.URL;
import java.util.ResourceBundle;

import DB.UserCRUD;
import Entities.User;
import UI.SplashScreen.SplashScreenController;
import Utils.PasswordFunctions;
import java.io.IOException;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.scene.paint.Color;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author Aziza
 */
public class LoginController implements Initializable {

    @FXML
    private Button loginBtn;
    @FXML
    private Button signupBtn;
    @FXML
    private TextField emailField;
    @FXML
    private PasswordField passwordText;
    @FXML
    private Label passwordLabel;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        passwordLabel.setOpacity(0);
        passwordLabel.setTextFill(Color.RED);

    }

    @FXML
    private void loginUser(ActionEvent event) {
        // Get the email and password from the text fields
        String email = emailField.getText();
        String password = passwordText.getText();
        if (email.isEmpty() || password.isEmpty()) {
            labelFadeOut();
            return;
        }

        password = PasswordFunctions.hashPassword(password);

        // Check if the user exists in the database
        UserCRUD userCRUD = new UserCRUD();
        User user = userCRUD.getUserByEmail(email);
        if (user != null) {
            if (user.getPassword().equals(password)) {
                User.setCurrent_user(user);
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
        } else {
            labelFadeOut();
        }
    }

    @FXML
    private void signupUser(ActionEvent event) {
        Parent root = null;
        try {
            root = FXMLLoader.load(getClass().getResource("../SignUp/SignUp.fxml"));
        } catch (IOException ex) {
        }

        Scene scene = new Scene(root);
        scene.setFill(Color.TRANSPARENT);
        Stage stage = new Stage();
        stage.setScene(scene);
        stage.show();
        signupBtn.getScene().getWindow().hide();
    }

    private void labelFadeOut() {
        passwordLabel.setOpacity(1);
        passwordLabel.setTextFill(Color.RED);
        passwordLabel.setText("Email or Password is Invalid !");
        new Thread(() -> {
            try {
                Thread.sleep(3000);
            } catch (InterruptedException ex) {
                System.out.println(ex.getMessage());
            }
            passwordLabel.setOpacity(0);
        }).start();

    }

}
