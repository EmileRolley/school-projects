package azul.datamodel;

public class Print {

	/** 
	 * Maximal characters number for the TUI's width.
	 */
	public static final int MAX_WIDTH = 159;

	public static String getNMinusChar(int n) {
		String res = "";

		while ( n-- > 0 )
			res += "-";

		return( res );
	 } 
           
	public static String completeWithCharTo(
		String strToComplete, char c, int lenToReach
	) {
		String strCompleted = strToComplete;

		while ( strCompleted.length() < lenToReach )
			strCompleted += c;

		return( strCompleted );
	}
	
	public static String stretch(String str) {
		return(
			Print.completeWithCharTo(str, ' ', Print.MAX_WIDTH - 1)
		);
	}
}