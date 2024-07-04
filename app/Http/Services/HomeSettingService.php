<?php
    
    namespace App\Http\Services;
    
    use App\Models\HomeSetting;
    use App\Models\SiteSettings;
    use Illuminate\Support\Facades\File;
    use Intervention\Image\ImageManager;
    use Ramsey\Uuid\Uuid;
    
    class HomeSettingService {
        
        public function save ( $request ) {
            $homeSettings = HomeSetting ::first ();
            
            if ( !$homeSettings ) {
                return HomeSetting ::create ( [
                                                  'banner_1' => $this -> upload_image ( $request, 'banner-1' ),
                                                  'banner_2' => $this -> upload_image ( $request, 'banner-2' ),
                                                  'banner_3' => $this -> upload_image ( $request, 'banner-3' ),
                                                  'banner_4' => $this -> upload_image ( $request, 'banner-4' ),
                                              ] );
            }
            else {
                if ( $request -> hasFile ( 'banner-1' ) )
                    $homeSettings -> banner_1 = $this -> upload_image ( $request, 'banner-1' );
                
                if ( $request -> hasFile ( 'banner-2' ) )
                    $homeSettings -> banner_2 = $this -> upload_image ( $request, 'banner-2' );
                
                if ( $request -> hasFile ( 'banner-3' ) )
                    $homeSettings -> banner_3 = $this -> upload_image ( $request, 'banner-3' );
                
                if ( $request -> hasFile ( 'banner-4' ) )
                    $homeSettings -> banner_4 = $this -> upload_image ( $request, 'banner-4' );
                
                $homeSettings -> update ();
            }
        }
        
        private function upload_image ( $request, $fileName ): string {
            $savePath = './uploads/hom-settings/banners/';
            $path     = '';
            
            File ::ensureDirectoryExists ( $savePath, 0755, true );
            
            if ( $request -> hasFile ( $fileName ) ) {
                $filenameWithExt = $request -> file ( $fileName ) -> getClientOriginalName ();
                $filename        = pathinfo ( $filenameWithExt, PATHINFO_FILENAME );
                $extension       = $request -> file ( $fileName ) -> getClientOriginalExtension ();
                $fileNameToStore = $filename . '-' . time () . '.' . $extension;
                $path            = $request -> file ( $fileName ) -> storeAs ( $savePath, $fileNameToStore );
                $image           = ImageManager ::imagick () -> read ( $path );
                $image -> scale ( width: 600 );
                $image -> save ( $path );
                return asset ( $path );
            }
            return $path;
        }
    }
