package azul.datamodel;

import java.util.*;

public class Board {

    private ArrayList<PlayerBoard>	playerBoards;
	private ArrayList<Factory> 		factories;
    private Center					center;
    private OffSide					offSide;
    private Game					game;

    public Board(int nbFactories, Game game) {    
        playerBoards = new ArrayList<PlayerBoard>();
		factories = new ArrayList<Factory>();

        for (int i = 0; i < nbFactories; i++)
            factories.add( new Factory(i) );

        center = new Center();
        offSide = new OffSide( game.getVariant() );
    }

    public Center getCenter() {
        return( center );
    }

    public ContainerXList getFactory(int id) {
        for (Factory f : factories)
            if ( f.getId() == id )
				return f;

        return null;
    }

    public OffSide getOffside() {
        return( offSide );
    }

    public ArrayList<PlayerBoard> getPlayerBoards() {
        return( playerBoards );
    }
    /**
     * @return true if the center and all the factories are empty
     */
    public boolean isEmpty() {
        if ( !center.isEmpty() )
            return false;

        for (Factory factory : factories)
            if ( !factory.isEmpty() )
				return false;

        return true;
    }

    /**
     * @return false if a factory could not be filled completly.
     */
    public boolean preparatoryPhase(String variant) {
		boolean filled = fillFactories();

        if ( !filled )
            return false;
		center.add( Bag.createTiles(1, Color.FIRST) );

        return true;
    }

    /**
     * @return false if a factory cannot be filled completely
     */
    private boolean fillFactories() {
        for (Factory factory : factories) {
			ArrayList<Tile> tiles = offSide.getBag().pick(factory.getMaximalSizeX());

            if ( tiles.size() != factory.getMaximalSizeX() )
                return false;
            factory.add(tiles);
        }
        return true;
    }

    public String toString() {
		String s = "";

        for (Factory factory : factories)
            s += factory.toString() + "\n";
        s += center.toString();

        return s;
    }

	/** ------------------ TUI ------------------ */

	public void print() {
		System.out.println(
			Print.completeWithCharTo("- Azul ", '-', Print.MAX_WIDTH)
		);
		printBlankLine();
		printFactories();
		printBlankLine();
		System.out.println( center.toString() );
		printBlankLine();
		printPlayerBoards();	
		System.out.println( Print.completeWithCharTo("-", '-', Print.MAX_WIDTH));
	}

	private void printBlankLine() {
		System.out.println(
			Print.completeWithCharTo("|", ' ', Print.MAX_WIDTH-1) + "|"
		);
	}

	private void printFactories() {
		Iterator<Factory> ite = factories.iterator();
		
		printFactoriesBis( ite, 5 );
		if  ( factories.size() > 5 )
			printFactoriesBis( ite, factories.size() );
	}

	private void printFactoriesBis(Iterator<Factory> ite, int max) {
		String firstLine = "|  ";
		String secondLine = "|  ";
		String thirdLine = "|  ";
		int  i = 0;

		while ( ite.hasNext() && i++ < max ) {
			Factory f = ite.next();

			firstLine += f.getFirstLine() + "  ";
			secondLine += f.getSecondLine() + "  ";
			thirdLine += f.getThirdLine() + "  ";
		}

		System.out.println(
			Print.stretch(firstLine) + "|\n"
			+ Print.stretch(secondLine) + "|\n"
			+ Print.stretch(thirdLine) + "|"
		);
	}

	private void printPlayerBoards() {
		for (PlayerBoard pb : playerBoards) {
			System.out.print( pb.toString() );
			printBlankLine();
		}
	}
}