from gtts import gTTS
import speech_recognition as sr
import os
os.system("pip install --upgrade pip")
os.system("pip3 install speech_recognition")


def soyle(sesMetin):
    print(sesMetin)
    tts = gTTS(text=sesMetin, lang='tr')
    tts.save("audio.mp3")
    os.system("audio.mp3")


def konusma():
    r = sr.Recognizer()
    with sr.Microphone() as source:
        print("Söyle bakalım")
        r.adjust_for_ambient_noise(source)
        audio = r.listen(source)
        try:
            gelen = str(r.recognize_google(audio, language="tr-tr"))
            gelen = gelen.lower()
            print("Söyledin: "+gelen)
            soyle(gelen)
            if (gelen == "merhaba"):
                print("Merhaba, Senin için ne yapabilirim?")
            elif (gelen == "nasılsın"):
                print("İyiyim, Sen nasılsın?")
            elif (gelen == "görüşürüz"):
                print("Hoşçakal")
        except sr.WaitTimeoutError:
            print("Dinleme zaman aşımına uğradı")
        except sr.UnknownValueError:
            print("Ne dediğini anlayamadım")
        except sr.RequestError:
            print("İnternete bağlanamıyorum")
        except:
            print("Bir Hata oluştu")
    input("Tekrar konuşmak için ´Enter´ tuşuna basın..")


while True:
    konusma()
