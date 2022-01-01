package azul.datamodel;

public class Tile {
	
	private Color color;
	/** Should be remove ? */
    private TileContainerX container;

	public Tile(Color color) {
		this( color, null );
	}

    public Tile(Color color, TileContainerX container) {
		this.color = color;
		this.container = container;
    }

    public Color getColor() {
        return( color );
    }

    public void setColor(Color color) {
		this.color = color;
	}
	
	@Override
	public String toString() {
		return( color.toString() );
	}
}