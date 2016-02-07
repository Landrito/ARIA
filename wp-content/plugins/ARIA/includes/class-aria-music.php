<?php

/**
 * The file that provides music uploading/downloading functionality.
 *
 * A class definition that includes attributes and functions that allow the
 * festival chairman to upload and download music.
 *
 * @link       http://wesleykepke.github.io/ARIA/
 * @since      1.0.0
 *
 * @package    ARIA
 * @subpackage ARIA/includes
 */

// Require the ARIA API
require_once("class-aria-api.php");

/**
 * The create competition class.
 *
 * @since      1.0.0
 * @package    ARIA
 * @subpackage ARIA/includes
 * @author     KREW
 */
class ARIA_Music {

  /**
   * This function will parse the contents of the csv file and upload content to
   * the NNMTA music database.
   *
   * Using the csv file that the user has uploaded, this function will parse
   * through the music content for each song and add it to the NNMTA music
   * database.
   *
   * @param Entry Object  $entry  The entry object from the upload form.
   * @param Form Object   $form   The form object that contains $entry.
   *
   * @since 1.0.0
   * @author KREW
   */
  public static function aria_add_music_from_csv($entry, $form) {
    $num_song_elements_no_image = 5;
    $num_song_elements_with_image = 6;

    // locate the full path of the csv file
    $csv_music_file = aria_get_music_csv_file_path($entry, $form);

    // parse csv file and add all music data to an array
    $all_songs = array();
    if (($file_ptr = fopen($csv_music_file, "r")) !== FALSE) {
      // remove all data that is already in the database
      //aria_remove_all_music_from_nnmta_database();

      // add new music
      while (($single_song_data = fgetcsv($file_ptr, 1000, ",")) !== FALSE) {
        // no image
        if (count($single_song_data) === $num_song_elements_no_image) {
          $all_songs[] = array (
            '1' => $single_song_data[0],
            '2' => $single_song_data[1],
            '3' => $single_song_data[2],
            '4' => $single_song_data[3],
            '5' => $single_song_data[4],
          );
        }

        // image
        elseif (count($single_song_data) === $num_song_elements_with_image) {
          /*
          $all_songs[] = array (
            '1' => $single_song_data[0],
            '2' => $single_song_data[1],
            '3' => $single_song_data[2],
            '4' => $single_song_data[3],
            '5' => $single_song_data[4],
            '6' => $single_song_data[5],
          ); */
        }
      }
    }

    // add all song data from array into the database
    $new_song_ids = GFAPI::add_entries($all_songs, aria_get_nnmta_database_form_id());
    if (is_wp_error($new_song_ids)) {
      wp_die($new_song_ids->get_error_message());
    }

    // remove filename from upload folder
    //print_r($all_songs);
    unlink($csv_music_file);
    unset($all_songs);
  }

  /**
   * This function will remove all of the music from the NNMTA music database.
   *
   * This function was created to support the scenario when the festival
   * chariman needs to update the music in the NNMTA music database. In order to
   * do this, all of the existing data is removed from the database prior to
   * adding all of the new data. This ensures that the new data is added
   * appropriately without accidentally adding old, possibly unwanted music
   * data.
   *
   * @since 1.0.0
   * @author KREW
   */
  private static function aria_remove_all_music_from_nnmta_database() {
    // to be implemented
  }
}
