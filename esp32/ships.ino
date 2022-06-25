#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClientSecure.h>
#include <UniversalTelegramBot.h>
#include <ArduinoJson.h>

#define LED     2
#define BUZZER  4

const char WIFI_SSID[] = "WS Clown Project 2.4G";
const char WIFI_PASSWORD[] = "membadutbersama";

String GET_SERVER = "http://192.168.1.23/ships/get";

#define BOTtoken "1789522731:AAH2h-vGPiCPRFqfkL4M6KtIeG3tgZL6NQ8"
#define CHAT_ID "908856036"

WiFiClientSecure client;
UniversalTelegramBot bot(BOTtoken, client);

int botRequestDelay = 1000;
unsigned long lastTimeBotRan;

int notif;

void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600); 
  pinMode(LED, OUTPUT);
  pinMode(BUZZER, OUTPUT);

  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  delay(1000);
}

void loop() {
  // put your main code here, to run repeatedly:
  if(WiFi.status()== WL_CONNECTED){
    HTTPClient http;
  
    http.begin(GET_SERVER);
    int httpCode = http.GET();
  
    if(httpCode > 0) {
      if(httpCode == HTTP_CODE_OK) {
        String payload = http.getString();
        notif = payload.toInt();
        Serial.println(payload);
      } else {
        Serial.printf("[HTTP] GET... code: %d\n", httpCode);
      }
    }
    else {
      Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }
  
    http.end();
  }

  if(notif == 0){
    digitalWrite(LED, LOW);
    digitalWrite(BUZZER, LOW);
    Serial.println("Aman");
    if (millis() > lastTimeBotRan + botRequestDelay)  {
      bot.sendMessage(chat_id, "AMAN", "");
      lastTimeBotRan = millis();
    }
  }
  else if(notif == 1){
    Serial.println("Bahaya");
    if (millis() > lastTimeBotRan + botRequestDelay)  {
      bot.sendMessage(chat_id, "BAHAYA", "");
      lastTimeBotRan = millis();
    }
    
    digitalWrite(LED, HIGH);
    digitalWrite(BUZZER, HIGH);
    delay(1000);
    digitalWrite(LED, LOW);
    digitalWrite(BUZZER, LOW);
    delay(500);
  }

}
