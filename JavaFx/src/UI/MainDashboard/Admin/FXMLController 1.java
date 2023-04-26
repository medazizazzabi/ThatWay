/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package UI.MainDashboard.Admin;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;

/**
 * FXML Controller class
 *
 * @author Aziza
 */
public class FXMLController implements Initializable {

    @FXML
    private Button btn1;
    @FXML
    private Button btn2;
    @FXML
    private Button btn3;
    @FXML
    private Button btn4;
    @FXML
    private Button btn5;
    @FXML
    private Button btn6;
    @FXML
    private Button back;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }

    @FXML
    private void handleButtonAction(ActionEvent event) {
        try {
            Button clickedButton = (Button) (event.getSource());
            String fxmlFileName = "";

            switch (clickedButton.getId()) {
                case "btn1":
                    fxmlFileName = "../../PathManagement/PathManager/PathManager.fxml";
                    break;
                case "btn2":
                    fxmlFileName = "../../StationManagement/dashboard_1.fxml";
                    break;
                case "btn3":
                    fxmlFileName = "../../VehiculeManagement/VehiculeBack/VehiculeBack.fxml";
                    break;
                case "btn4":
                    fxmlFileName = "./FXML.fxml";
                    break;
                case "btn5":
                    fxmlFileName = "../../ComplaintManagement/ComplaintsTable.fxml";
                    break;
                case "btn6":
                    fxmlFileName = "../../SubscriptionManagement/Admin1_1.fxml";
                    break;
                case "back":
                    fxmlFileName = "../Dashboard.fxml";
                    break;
                default:
                    break;
            }

            Parent root = FXMLLoader.load(getClass().getResource(fxmlFileName));
            Scene scene = new Scene(root);
            Stage stage = (Stage) (clickedButton.getScene().getWindow());
            stage.setScene(scene);
            stage.show();
        } catch (IOException ex) {
            Logger.getLogger(FXMLController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }


}
