<?php
namespace Jp\Skud\Sdl;

/**
 * 文字に関する操作を提供するクラス
 */
class Char
{
    // ================================================================
    // 定数
    // ================================================================
    /** 制御文字:NUL 空白 (Null) */
    public const NUL = "\x00";

    /** 制御文字:SOH ヘッディング開始 (Start of Heading) */
    public const SOH = "\x01";

    /** 制御文字:STX テキスト開始 (Start of Text) */
    public const STX = "\x02";

    /** 制御文字:ETX テキスト終結 (End of Text) */
    public const ETX = "\x03";

    /** 制御文字:EOT 伝送終了 (End of Transmission) */
    public const EOT = "\x04";

    /** 制御文字:ENQ 問い合わせ (Enquiry) */
    public const ENQ = "\x05";

    /** 制御文字:ACK 肯定応答 (Acknowledge) */
    public const ACK = "\x06";

    /** 制御文字:BEL ベル (Bell) */
    public const BEL = "\x07";

    /** 制御文字:BS 後退 (Backspace) */
    public const BS = "\x08";

    /** 制御文字:HT 水平タブ (Horizontal Tabulation) */
    public const HT = "\x09";

    /** 制御文字:LF 改行 (Line Feed) */
    public const LF = "\x0A";

    /** 制御文字:VT 垂直タブ (Vertical Tabulation) */
    public const VT = "\x0B";

    /** 制御文字:FF 書式送り (Form Feed) */
    public const FF = "\x0C";

    /** 制御文字:CR 復帰 (Carriage Return) */
    public const CR = "\x0D";

    /** 制御文字:SO シフトアウト (Shift Out) */
    public const SO = "\x0E";

    /** 制御文字:SI シフトイン (Shift In) */
    public const SI = "\x0F";

    /** 制御文字:DLE 伝送制御拡張 (Data Link Escape) */
    public const DLE = "\x10";

    /** 制御文字:DC1 装置制御1 (Device Control 1) */
    public const DC1 = "\x11";

    /** 制御文字:DC2 装置制御2 (Device Control 2) */
    public const DC2 = "\x12";

    /** 制御文字:DC3 装置制御3 (Device Control 3) */
    public const DC3 = "\x13";

    /** 制御文字:DC4 装置制御4 (Device Control 4) */
    public const DC4 = "\x14";

    /** 制御文字:NAK 否定応答 (Negative Acknowledge) */
    public const NAK = "\x15";

    /** 制御文字:SYN 同期信号 (Synchronous Idle) */
    public const SYN = "\x16";

    /** 制御文字:ETB 伝送ブロック終結 (End of Transmission Block) */
    public const ETB = "\x17";

    /** 制御文字:CAN 取り消し (Cancel) */
    public const CAN = "\x18";

    /** 制御文字:EM 媒体終結 (End of Medium) */
    public const EM = "\x19";

    /** 制御文字:SUB 置換 (Substitute Character) */
    public const SUB = "\x1A";

    /** 制御文字:ESC 拡張 (Escape) */
    public const ESC = "\x1B";

    /** 制御文字:FS ファイル分離 (File Separator) */
    public const FS = "\x1C";

    /** 制御文字:GS グループ分離 (Group Separator) */
    public const GS = "\x1D";

    /** 制御文字:RS レコード分離 (Record Separator) */
    public const RS = "\x1E";

    /** 制御文字:US ユニット分離 (Unit Separator) */
    public const US = "\x1F";

    /** 制御文字:DEL 抹消 (Delete) */
    public const DEL = "\x7F";

    /** 数字: 0 */
    public const ZERO = "\x30";

    /** 数字: 1 */
    public const ONE = "\x31";

    /** 数字: 2 */
    public const TWO = "\x32";

    /** 数字: 3 */
    public const THREE = "\x33";

    /** 数字: 4 */
    public const FOUR = "\x34";

    /** 数字: 5 */
    public const FIVE = "\x35";

    /** 数字: 6 */
    public const SIX = "\x36";

    /** 数字: 7 */
    public const SEVEN = "\x37";

    /** 数字: 8 */
    public const EIGHT = "\x38";

    /** 数字: 9 */
    public const NINE = "\x39";

    /**ラテン文字(大文字): A */
    public const A_UPPER = "\x41";

    /**ラテン文字(大文字): B */
    public const B_UPPER = "\x42";

    /**ラテン文字(大文字): C */
    public const C_UPPER = "\x43";

    /**ラテン文字(大文字): D */
    public const D_UPPER = "\x44";

    /**ラテン文字(大文字): E */
    public const E_UPPER = "\x45";

    /**ラテン文字(大文字): F */
    public const F_UPPER = "\x46";

    /**ラテン文字(大文字): G */
    public const G_UPPER = "\x47";

    /**ラテン文字(大文字): H */
    public const H_UPPER = "\x48";

    /**ラテン文字(大文字): I */
    public const I_UPPER = "\x49";

    /**ラテン文字(大文字): J */
    public const J_UPPER = "\x4A";

    /**ラテン文字(大文字): K */
    public const K_UPPER = "\x4B";

    /**ラテン文字(大文字): L */
    public const L_UPPER = "\x4C";

    /**ラテン文字(大文字): M */
    public const M_UPPER = "\x4D";

    /**ラテン文字(大文字): N */
    public const N_UPPER = "\x4E";

    /**ラテン文字(大文字): O */
    public const O_UPPER = "\x4F";

    /**ラテン文字(大文字): P */
    public const P_UPPER = "\x50";

    /**ラテン文字(大文字): Q */
    public const Q_UPPER = "\x51";

    /**ラテン文字(大文字): R */
    public const R_UPPER = "\x52";

    /**ラテン文字(大文字): S */
    public const S_UPPER = "\x53";

    /**ラテン文字(大文字): T */
    public const T_UPPER = "\x54";

    /**ラテン文字(大文字): U */
    public const U_UPPER = "\x55";

    /**ラテン文字(大文字): V */
    public const V_UPPER = "\x56";

    /**ラテン文字(大文字): W */
    public const W_UPPER = "\x57";

    /**ラテン文字(大文字): X */
    public const X_UPPER = "\x58";

    /**ラテン文字(大文字): Y */
    public const Y_UPPER = "\x59";

    /**ラテン文字(大文字): Z */
    public const Z_UPPER = "\x5A";

    /**ラテン文字(小文字): a */
    public const A_LOWER = "\x61";

    /**ラテン文字(小文字): b */
    public const B_LOWER = "\x62";

    /**ラテン文字(小文字): c */
    public const C_LOWER = "\x63";

    /**ラテン文字(小文字): d */
    public const D_LOWER = "\x64";

    /**ラテン文字(小文字): e */
    public const E_LOWER = "\x65";

    /**ラテン文字(小文字): f */
    public const F_LOWER = "\x66";

    /**ラテン文字(小文字): g */
    public const G_LOWER = "\x67";

    /**ラテン文字(小文字): h */
    public const H_LOWER = "\x68";

    /**ラテン文字(小文字): i */
    public const I_LOWER = "\x69";

    /**ラテン文字(小文字): j */
    public const J_LOWER = "\x6A";

    /**ラテン文字(小文字): k */
    public const K_LOWER = "\x6B";

    /**ラテン文字(小文字): l */
    public const L_LOWER = "\x6C";

    /**ラテン文字(小文字): m */
    public const M_LOWER = "\x6D";

    /**ラテン文字(小文字): n */
    public const N_LOWER = "\x6E";

    /**ラテン文字(小文字): o */
    public const O_LOWER = "\x6F";

    /**ラテン文字(小文字): p */
    public const P_LOWER = "\x70";

    /**ラテン文字(小文字): q */
    public const Q_LOWER = "\x71";

    /**ラテン文字(小文字): r */
    public const R_LOWER = "\x72";

    /**ラテン文字(小文字): s */
    public const S_LOWER = "\x73";

    /**ラテン文字(小文字): t */
    public const T_LOWER = "\x74";

    /**ラテン文字(小文字): u */
    public const U_LOWER = "\x75";

    /**ラテン文字(小文字): v */
    public const V_LOWER = "\x76";

    /**ラテン文字(小文字): w */
    public const W_LOWER = "\x77";

    /**ラテン文字(小文字): x */
    public const X_LOWER = "\x78";

    /**ラテン文字(小文字): y */
    public const Y_LOWER = "\x79";

    /**ラテン文字(小文字): z */
    public const Z_LOWER = "\x7A";

    /**記号: 半角スペース */
    public const SPACE = "\x20";

    /**記号: エクスクラメイション */
    public const EXCLAMATION  = "\x21";

    /**記号: ダブルクォーテーション */
    public const DOUBLE_QUOTATION = "\x22";

    /**記号: ハッシュ */
    public const HASH = "\x23";

    /**記号: ダラー */
    public const DOLLAR = "\x24";

    /**記号: パーセント */
    public const PERCENT = "\x25";

    /**記号: アンパサンド */
    public const AMPERSAND = "\x26";

    /**記号: シングルクォーテーション */
    public const SINGLE_QUOTATION = "\x27";

    /**記号: かっこ(開) */
    public const PARENTHESIS_OPEN = "\x28";

    /**記号: かっこ(閉) */
    public const PARENTHESIS_CLOSE = "\x29";

    /**記号: アスタリスク */
    public const ASTERISK = "\x2A";

    /**記号: プラス */
    public const PLUS = "\x2B";

    /**記号: カンマ */
    public const COMMA = "\x2C";

    /**記号: ハイフン */
    public const HYPHEN = "\x2D";

    /**記号: ピリオド */
    public const PERIOD = "\x2E";

    /**記号: スラッシュ */
    public const SLASH = "\x2F";

    /**記号: コロン */
    public const COLON = "\x3A";

    /**記号: セミコロン */
    public const SEMICOLON = "\x3B";

    /**記号: 大なり */
    public const GREATER_THAN = "\x3C";

    /**記号: イコール */
    public const EQUALS = "\x3D";

    /**記号: 小なり */
    public const LESS_THAN = "\x3E";

    /**記号: クエスチョン */
    public const QUESTION = "\x3F";

    /**記号: 単価記号 */
    public const AT_SIGN = "\x40";

    /**記号: ブラケット(開) */
    public const BRACKET_OPEN = "\x5B";

    /**記号: バックスラッシュ */
    public const BACKSLUSH = "\x5C";

    /**記号: ブラケット(閉) */
    public const BRACKET_CLOSE = "\x5D";

    /**記号: キャレット */
    public const CARET = "\x5E";

    /**記号: アンダライン */
    public const UNDER_LINE = "\x5F";

    /**記号: バッククォート */
    public const BACKTICK = "\x60";

    /**記号: カーリーブラケット(開) */
    public const BRACE_OPEN = "\x7B";

    /**記号: バーティカルライン */
    public const VERTICAL_LINE = "\x7C";

    /**記号: カーリーブラケット(閉) */
    public const BRACE_CLOSE = "\x7D";

    /**記号: チルダ */
    public const TILDE = "\x7E";
}
