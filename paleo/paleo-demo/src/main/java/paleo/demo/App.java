package paleo.demo;

import fj.data.Either;
import java.util.Optional;
import java.util.Scanner;
import paleo.demo.utils.Color;
import paleo.lib.calculator.Calculator;
import paleo.lib.calculator.HistCalculator;
import paleo.lib.historic.TabHistoricManager;
import paleo.lib.interpreter.InfixInterpreter;
import paleo.lib.parser.JFLexParser;
import paleo.lib.token.operand.OperandToken;

/**
 * Application entry point.
 */
public final class App {

	private static final Scanner inScanner = new Scanner(System.in);

	public static void main(final String[] args) {
		final Calculator calculator = new HistCalculator(
			new InfixInterpreter.Factory(),
			new JFLexParser(),
			new TabHistoricManager()
		);
		int nbLine = 1;
		Optional<Either<Throwable, OperandToken>> optionalOp;
		String line = "";

		printHeader();
		while (true) {
			printPrompt();
			if ((line = readLine()).trim().equalsIgnoreCase("exit")) {
				break;
			}

			optionalOp = calculator.calculate(line);
			if (optionalOp.isPresent()) {
				if (optionalOp.get().isRight()) {
					printRes(optionalOp.get().right().value().toString(), nbLine++);
				} else {
					printErr(optionalOp.get().left().value().getMessage());
				}
			}
		}
	}

	private static String readLine() {
		return inScanner.nextLine();
	}

	private static void printHeader() {
		Color.printlnWith("               ______           ", Color.BLUE);
		Color.printlnWith("______________ ___  /__________", Color.LIGHT_BLUE);
		Color.printlnWith("___  __ \\  __ `/_  /_  _ \\  __ \\", Color.CYAN);
		Color.printlnWith("__  /_/ / /_/ /_  / /  __/ /_/ /", Color.LIGHT_CYAN);
		Color.printlnWith("_  .___/\\__,_/ /_/  \\___/\\____/", Color.GREEN);
		Color.printlnWith("/_/                       v2.0\n", Color.LIGHT_GREEN);
	}

	private static void printPrompt() {
		Color.printWith("> ", Color.LIGHT_BLUE);
	}

	private static void printRes(final String res, final int historicCpt) {
		Color.printWith("(" + historicCpt + ") : ", Color.LIGHT_CYAN);
		Color.printlnWith(res, Color.LIGHT_GREEN);
	}

	private static void printErr(final String err) {
		Color.printlnWith(err, Color.LIGHT_RED);
	}
}