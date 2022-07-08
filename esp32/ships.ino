#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClientSecure.h>
#include <UniversalTelegramBot.h>
#include <ArduinoJson.h>

#define LED     2
#define BUZZER  4
#define Button  1

const char WIFI_SSID[] = "WS Clown Project 2.4G";
const char WIFI_PASSWORD[] = "membadutbersama";

String GET_SERVER = "http://192.168.1.12/ships/get";
String STOP_URL = "http://192.168.1.12/ships/change";

#define BOTtoken "5441350609:AAGpFI3X350uvCydNxjZS5PJp7ay4mSY-os"
#define CHAT_ID "908856036"

WiFiClientSecure client;
UniversalTelegramBot bot(BOTtoken, client);

int botRequestDelay = 1000;
unsigned long lastTimeBotRan;

int notif = 0;
int savenotif = 0;
int lastnotif = 0;
int kirim;
int state = 0;
int laststate = 0;
int send = 0;
int lastsend = 0;

unsigned long currentMillis;
unsigned long previousMillis = 0;

void setup() {
  // put your setup code here, to run once:
//  Serial.begin(9600); 
  pinMode(LED, OUTPUT);
  pinMode(BUZZER, OUTPUT);
  pinMode(Button, INPUT_PULLUP);

  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  client.setCACert(TELEGRAM_CERTIFICATE_ROOT);
//  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
//    Serial.print(".");
  }

//  Serial.println("");
//  Serial.print("Connected to WiFi network with IP Address: ");
//  Serial.println(WiFi.localIP());

  bot.sendMessage(CHAT_ID, "Bot started up", "");

  delay(1000);
}

void loop() {
  // put your main code here, to run repeatedly:
//  if(WiFi.status()== WL_CONNECTED){
    HTTPClient http;
  
    http.begin(GET_SERVER);
    int httpCode = http.GET();
  
    if(httpCode > 0) {
      if(httpCode == HTTP_CODE_OK) {
        String payload = http.getString();
        notif = payload.toInt();
//        Serial.println(payload);
      }
  
    http.end();
  }

  kirim = digitalRead(Button);

  if(kirim == 0){
    savenotif = 0;
    HTTPClient http;
  
    http.begin(STOP_URL);
    int httpCode = http.GET();
  
    if(httpCode > 0) {
      if(httpCode == HTTP_CODE_OK) {
        digitalWrite(LED, HIGH);
        delay(1000);
        digitalWrite(LED, LOW);
      }
    http.end();
    }
  }
  
  if(notif == 0){
    bot.sendMessage(CHAT_ID, "AMAN", "");
  }
  else if(notif == 1){
    bot.sendMessage(CHAT_ID, "BAHAYA", "");
  }

  if(notif == 0){
    digitalWrite(BUZZER, LOW);
  }
  else if(notif == 1){
    digitalWrite(BUZZER, HIGH);
    delay(1000);
    digitalWrite(BUZZER, LOW);
    delay(500);
  }

}
//  currentMillis = millis();
//  if (currentMillis - previousMillis >= 3000) {
//    previousMillis = currentMillis;
//    savenotif = notif;
//  }
//  lastsend = send;
//  lastnotif = notif;
