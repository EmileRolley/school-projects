package azul.datamodel;

import java.util.*;

public class Test {
	public static void main(String[] args) {
		testGregoire();
		//testEmile();
	}

	private static void testGregoire() {
		Game game = new Game(2, "Classic");
		game.play();
		System.out.println("fin");
	}

	private static void testEmile() {
		testTile();
		testTileContainerX();
		testTileContainerXY();
		testCenter();
		testFactory();
		testBag();
		testFloor();
		testPatternLines();
		testWall();
	}

	private static void testTile() {
		Tile blueTile = new Tile( Color.BLUE );

		System.out.println( "\n=========== Test : Tile ==========\n" );
		System.out.println( blueTile );
	}

	private static void testTileContainerX() {
		System.out.println( "\n=========== Test : TileContainerX ==========\n" );
		Tile blueTile = new Tile( Color.BLUE );
		TileContainerX container = new TileContainerX( 0, blueTile, null );
		
		System.out.println( container );
		System.out.println( "contains(purple) = " + container.contains(Color.PURPLE) );
		System.out.println( "contains(blue) = " + container.contains(Color.BLUE) );
		System.out.println( "contains(all) = " + container.contains(Color.ALL) );
		System.out.println( "getNbHorizontalAdjacentTiles(left) = "
							+ container.getNbHorizontalAdjacentTiles(Direction.LEFT) );
		System.out.println( "getNbHorizontalAdjacentTiles(right) = "
							+ container.getNbHorizontalAdjacentTiles(Direction.LEFT) );
		System.out.println( "getNbHorizontalAdjacentTiles(both) = "
							+ container.getNbHorizontalAdjacentTiles(Direction.BOTH) );
	}

	private static void testTileContainerXY() {
		System.out.println( "\n=========== Test : TileContainerXY ==========\n" );
		Tile blueTile = new Tile( Color.BLUE );
		TileContainerXY container = new TileContainerXY( 0, 0, blueTile, null, Color.BLUE );
		
		System.out.println( container );
		System.out.println( "getNbVerticallAdjacentTiles(up) = "
							+ container.getNbVerticalAdjacentTiles(Direction.UP) );
		System.out.println( "getNbVerticalAdjacentTiles(down) = "
							+ container.getNbVerticalAdjacentTiles(Direction.DOWN) );
		System.out.println( "getNbVerticalAdjacentTiles(both) = "
							+ container.getNbVerticalAdjacentTiles(Direction.BOTH) );
		System.out.println( "isColorAccepted(blue) = "
							+ container.isColorAccepted(Color.BLUE));
		System.out.println( "isColorAccepted(white) = "
							+ container.isColorAccepted(Color.WHITE));
		System.out.println( "isColorAccepted(all) = "
							+ container.isColorAccepted(Color.ALL));
	}

	private static void testCenter() {
		System.out.println( "\n=========== Test : Center ==========\n" );
		Center center = new Center();

		System.out.println( center );
		center.add( new Tile(Color.PURPLE) ); 
		System.out.println( "Adds a purple tile." );
		System.out.println( center );
		center.addFirstPlayerTile();
		System.out.println( "Adds a first player tile." );
		System.out.println( center );
		center.add( new Tile(Color.BLUE) ); 
		System.out.println( "Adds a blue tile." );
		System.out.println( center );
		center.add( new Tile(Color.PURPLE) ); 
		System.out.println( "Adds a purple tile." );
		System.out.println( center );

		ArrayList<Tile> purpleTiles = center.get( Color.PURPLE );

		System.out.println( "Get purple tiles" );
		System.out.println( Arrays.toString(purpleTiles.toArray()) );
		System.out.println( center );

		center.add( new Tile(Color.YELLOW) ); 
		System.out.println( "Adds a yellow tile." );
		System.out.println( center );
	}

	private static void testFactory() {
		System.out.println( "\n=========== Test : Factory ==========\n" );
		Factory factory = new Factory(0);
		ArrayList<Tile> tiles = new ArrayList<Tile>();

		tiles.add( new Tile(Color.RED) );
		tiles.add( new Tile(Color.RED) );
		tiles.add( new Tile(Color.RED) );
		tiles.add( new Tile(Color.RED) );
		System.out.println( factory );
		System.out.println( "add an arraylist of 4 red tiles." );
		factory.add( tiles );
		System.out.println( factory );
		System.out.println( "add a purple tile." );
		factory.add( new Tile(Color.PURPLE) );
		System.out.println( factory );
		System.out.println( "get blue tiles." );
		tiles = factory.get( Color.BLUE );
		System.out.println( "arraylist -> " + Arrays.toString(tiles.toArray()) );
		System.out.println( factory );
		System.out.println( "get red tiles." );
		tiles = factory.get( Color.RED );
		System.out.println( "arraylist -> " + Arrays.toString(tiles.toArray()) );
		System.out.println( factory );

		tiles = new ArrayList<Tile>();
		tiles.add( new Tile(Color.RED) );
		tiles.add( new Tile(Color.YELLOW) );
		tiles.add( new Tile(Color.RED) );
		tiles.add( new Tile(Color.WHITE) );
		System.out.println( "add an arraylist of tiles." );
		System.out.println( "arraylist -> " + Arrays.toString(tiles.toArray()) );
		factory.add( tiles );
		System.out.println( factory );
		System.out.println( "get red tiles." );
		tiles = factory.get( Color.RED );
		System.out.println( "arraylist -> " + Arrays.toString(tiles.toArray()) );
		System.out.println( factory );
	}

	private static void testBag() {
		System.out.println( "\n=========== Test : Bag ==========\n" );
		Bag bag = new Bag( "default" );

		System.out.println( bag );
		System.out.println( "pick() = " + bag.pick() );
		System.out.println( bag );
		System.out.println( "pick(7) = " + Arrays.toString(bag.pick(7).toArray()) );
		System.out.println( bag );
		System.out.println( "pick(102) = " + Arrays.toString(bag.pick(102).toArray()) );
		System.out.println( bag );
		
		ArrayList<Tile> tiles = new ArrayList<Tile>();
		tiles.add( new Tile(Color.RED) );
		tiles.add( new Tile(Color.YELLOW) );
		tiles.add( new Tile(Color.RED) );
		tiles.add( new Tile(Color.WHITE) );
		tiles.add( new Tile(Color.YELLOW) );
		tiles.add( new Tile(Color.YELLOW) );
		tiles.add( new Tile(Color.RED) );
		tiles.add( new Tile(Color.WHITE) );
		tiles.add( new Tile(Color.RED) );
		tiles.add( new Tile(Color.WHITE) );
		System.out.println( "push : " + Arrays.toString(tiles.toArray()) );
		bag.push( tiles );
		System.out.println( bag );
	}

	private static void testFloor() {
		System.out.println( "\n=========== Test : Floor ==========\n" );
		Floor floor = new Floor( new Discard() );

		System.out.println( floor );
		System.out.println( "adds 3 tiles ");
		floor.add( new Tile(Color.FIRST) );
		floor.add( new Tile(Color.BLUE) );
		floor.add( new Tile(Color.RED) );
		System.out.println( floor );
		System.out.println( "contains first player tile ? " + floor.containsFirstPlayerTile() );
		System.out.println( "score = " + floor.calcScore() );
		System.out.println( "drain()" + Arrays.toString(floor.drain().toArray()) );
		System.out.println( floor );
	}

	private static void testPatternLines() {
		System.out.println( "\n=========== Test : PatternLines ==========\n" );
		PatternLines pattern = new PatternLines();

		System.out.println( pattern );
	}

	private static void testWall() {
		System.out.println( "\n=========== Test : Wall ==========\n" );
		Wall wall = new Wall( true );

		System.out.println( wall );
		System.out.println( "score = " + wall.getScore() );
		System.out.println( "add tiles." );
		wall.add( 0, new Tile(Color.BLUE) );
		wall.add( 0, new Tile(Color.YELLOW) );
		wall.add( 1, new Tile(Color.WHITE) );
		wall.add( 1, new Tile(Color.RED) );
		wall.add( 2, new Tile(Color.YELLOW) );
		wall.add( 3, new Tile(Color.WHITE) );
		System.out.println( wall );
		System.out.println( "score = " + wall.getScore() );
	}
	
	/** ------------------ TUI ------------------ */
	
	private static void testTUI() {
		// testBoardTUI();
		// testCenterTUI();
		// testFactoryTUI();
		// testPatternLinesTUI();
		// testWallTUI();
		// testFloorTUI();
		// testPlayerBoardTUI();
		testGameTUI();
	}
	
	private static <T> void printTab(T[] tab) {
		for (T e : tab)
			System.out.println( e );
	}

	private static void testBoardTUI() {
		Board board = new Board( 6, null );

		board.print();
	}

	private static void testCenterTUI() {
		Center center = new Center();

		center.add( new Tile(Color.FIRST) );
		center.add( new Tile(Color.BLUE) ); 
		center.add( new Tile(Color.WHITE) ); 
		center.add( new Tile(Color.BLUE) ); 
		center.add( new Tile(Color.RED) ); 
		center.add( new Tile(Color.YELLOW) ); 
		center.add( new Tile(Color.PURPLE) ); 
		center.add( new Tile(Color.RED) );
		System.out.println( center );

		center.get( Color.BLUE );
		System.out.println( center );
	}

	private static void testFactoryTUI() {
		Factory facto = new Factory( 0 );

		System.out.println( facto.getFirstLine() );
		System.out.println( facto.getSecondLine() );
		System.out.println( facto.getThirdLine() );

		System.out.println();

		facto.add( new Tile(Color.PURPLE) );
		facto.add( new Tile(Color.WHITE) );
		facto.add( new Tile(Color.YELLOW) );
		facto.add( new Tile(Color.RED) );

		System.out.println( facto.getFirstLine() );
		System.out.println( facto.getSecondLine() );
		System.out.println( facto.getThirdLine() );

		facto.get( Color.WHITE );
		
		System.out.println( facto.getFirstLine() );
		System.out.println( facto.getSecondLine() );
		System.out.println( facto.getThirdLine() );
	}

	private static void testPatternLinesTUI() {
		PatternLines pLines = new PatternLines();
		String[] linesStr = pLines.getLinesToString();

		printTab( linesStr );
	 }

	private static void testWallTUI() {
		Wall wall = new Wall( true );

		printTab( wall.getLinesToString() );

		wall.add( 0, new Tile(Color.BLUE) );
		wall.add( 0, new Tile(Color.YELLOW) );
		wall.add( 1, new Tile(Color.WHITE) );
		wall.add( 1, new Tile(Color.RED) );
		wall.add( 2, new Tile(Color.YELLOW) );
		wall.add( 3, new Tile(Color.WHITE) );

		printTab( wall.getLinesToString() );
	}

	private static void testFloorTUI() {
		Floor floor = new Floor( null );

		System.out.println( floor.getFirstLine() );
		System.out.println( floor.getSecondLine() );
		System.out.println( floor.getThirdLine() );

		floor.add( new Tile(Color.FIRST) );
		floor.add( new Tile(Color.BLUE) );
		floor.add( new Tile(Color.RED) );
		floor.add( new Tile(Color.PURPLE) );
		
		System.out.println( floor.getFirstLine() );
		System.out.println( floor.getSecondLine() );
		System.out.println( floor.getThirdLine() );
	}

	private static void testPlayerBoardTUI() {
		Player player = new Player( 0, null );
		PlayerBoard playerBoard = new PlayerBoard( player, null );

		System.out.println( playerBoard.toString() );
	}

	private static void testGameTUI() {
		Game game = new Game( 3, "classique" );
		game.print();
	}
}