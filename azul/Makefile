SRC = SRC
BIN = bin

all: datamodel launcher 

datamodel:
	javac $(SRC)/azul/datamodel/*.java -d $(BIN)

launcher:
	javac -cp $(BIN) src/azul/Launcher.java -d $(BIN)

run:
	java -cp $(BIN) azul.Launcher

test:
	java -cp $(BIN) azul.datamodel.Test

clean: clean-datamodel clean-launcher

clean-datamodel:
	rm -f $(BIN)/azul/datamodel/*.class

clean-launcher:
	rm -f $(BIN)/azul/Launcher.class
