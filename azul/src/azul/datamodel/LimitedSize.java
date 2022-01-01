package azul.datamodel;

public interface LimitedSize {
	public int getMaximalSizeX();

	default public int getMaximalSizeY() {
		return( 0 );
	}
}