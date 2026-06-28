--
-- PostgreSQL database dump
--

\restrict J9OmeMjuHCPk5woQfZOZFgBlqUeUqneoQmBcLFxZEqtedc66fH8dPc9Zz3kM8wI

-- Dumped from database version 18.3
-- Dumped by pg_dump version 18.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration bigint NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration bigint NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: catatan_siswas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.catatan_siswas (
    id bigint NOT NULL,
    guru_id bigint NOT NULL,
    siswa_id bigint NOT NULL,
    judul character varying(255) NOT NULL,
    isi text NOT NULL,
    kategori character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.catatan_siswas OWNER TO postgres;

--
-- Name: catatan_siswas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.catatan_siswas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.catatan_siswas_id_seq OWNER TO postgres;

--
-- Name: catatan_siswas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.catatan_siswas_id_seq OWNED BY public.catatan_siswas.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: izins; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.izins (
    id bigint NOT NULL,
    siswa_id bigint NOT NULL,
    tanggal date NOT NULL,
    alasan text NOT NULL,
    status character varying(255) NOT NULL,
    tipe character varying(255) DEFAULT 'Izin'::character varying NOT NULL,
    petugas_piket character varying(255),
    approved_by bigint,
    bukti character varying(255),
    latitude character varying(255),
    longitude character varying(255),
    CONSTRAINT izins_status_check CHECK (((status)::text = ANY (ARRAY[('pending'::character varying)::text, ('approve'::character varying)::text, ('reject'::character varying)::text])))
);


ALTER TABLE public.izins OWNER TO postgres;

--
-- Name: izins_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.izins_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.izins_id_seq OWNER TO postgres;

--
-- Name: izins_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.izins_id_seq OWNED BY public.izins.id;


--
-- Name: jadwals; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jadwals (
    id integer NOT NULL,
    user_id bigint,
    hari character varying,
    jam_mulai integer,
    jam_selesai integer,
    mata_pelajaran character varying,
    kelas character varying,
    semester character varying
);


ALTER TABLE public.jadwals OWNER TO postgres;

--
-- Name: jadwals_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jadwals_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jadwals_id_seq OWNER TO postgres;

--
-- Name: jadwals_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jadwals_id_seq OWNED BY public.jadwals.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: jurnal_mengajars; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jurnal_mengajars (
    id bigint NOT NULL,
    user_id bigint,
    tanggal date NOT NULL,
    mata_pelajaran character varying(255) NOT NULL,
    kelas character varying(255) NOT NULL,
    jam_mulai integer NOT NULL,
    jam_selesai integer NOT NULL,
    ringkasan_materi text NOT NULL,
    semester character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    qr_session_id bigint
);


ALTER TABLE public.jurnal_mengajars OWNER TO postgres;

--
-- Name: jurnal_mengajars_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jurnal_mengajars_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jurnal_mengajars_id_seq OWNER TO postgres;

--
-- Name: jurnal_mengajars_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jurnal_mengajars_id_seq OWNED BY public.jurnal_mengajars.id;


--
-- Name: jurnal_presensis; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jurnal_presensis (
    id bigint NOT NULL,
    jurnal_id bigint NOT NULL,
    nama_siswa character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.jurnal_presensis OWNER TO postgres;

--
-- Name: jurnal_presensis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jurnal_presensis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jurnal_presensis_id_seq OWNER TO postgres;

--
-- Name: jurnal_presensis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jurnal_presensis_id_seq OWNED BY public.jurnal_presensis.id;


--
-- Name: kelas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kelas (
    nama_kelas character varying,
    kode_kelas character varying,
    id bigint NOT NULL
);


ALTER TABLE public.kelas OWNER TO postgres;

--
-- Name: kelas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kelas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.kelas_id_seq OWNER TO postgres;

--
-- Name: kelas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kelas_id_seq OWNED BY public.kelas.id;


--
-- Name: mapels; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mapels (
    id integer NOT NULL,
    nama_mapel character varying
);


ALTER TABLE public.mapels OWNER TO postgres;

--
-- Name: mapels_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mapels_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.mapels_id_seq OWNER TO postgres;

--
-- Name: mapels_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.mapels_id_seq OWNED BY public.mapels.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: orangtuas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.orangtuas (
    id bigint NOT NULL,
    siswa_id bigint NOT NULL,
    nama character varying(255) NOT NULL,
    hubungan character varying(255) NOT NULL,
    no_hp character varying(255),
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.orangtuas OWNER TO postgres;

--
-- Name: orangtuas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.orangtuas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.orangtuas_id_seq OWNER TO postgres;

--
-- Name: orangtuas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.orangtuas_id_seq OWNED BY public.orangtuas.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: penilaians; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.penilaians (
    id bigint NOT NULL,
    user_id bigint,
    nama_siswa character varying(255) NOT NULL,
    kelas character varying(255) NOT NULL,
    mata_pelajaran character varying(255) NOT NULL,
    semester character varying(255) NOT NULL,
    nilai numeric(5,2),
    komponen character varying(255),
    tanggal date NOT NULL,
    keterangan text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.penilaians OWNER TO postgres;

--
-- Name: penilaians_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.penilaians_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.penilaians_id_seq OWNER TO postgres;

--
-- Name: penilaians_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.penilaians_id_seq OWNED BY public.penilaians.id;


--
-- Name: presensis; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.presensis (
    id integer NOT NULL,
    tanggal date,
    status character varying,
    jadwal_id bigint,
    siswa_id bigint,
    terlambat_menit integer DEFAULT 0,
    keterangan text,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.presensis OWNER TO postgres;

--
-- Name: presensis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.presensis_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.presensis_id_seq OWNER TO postgres;

--
-- Name: presensis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.presensis_id_seq OWNED BY public.presensis.id;


--
-- Name: qr_sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.qr_sessions (
    id bigint NOT NULL,
    jadwal_id bigint NOT NULL,
    tanggal date NOT NULL,
    token character varying(255) NOT NULL,
    expired_at timestamp(0) without time zone NOT NULL,
    guru_id bigint,
    status character varying(20) DEFAULT 'aktif'::character varying,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.qr_sessions OWNER TO postgres;

--
-- Name: qr_sessions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.qr_sessions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.qr_sessions_id_seq OWNER TO postgres;

--
-- Name: qr_sessions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.qr_sessions_id_seq OWNED BY public.qr_sessions.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: siswas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.siswas (
    id bigint NOT NULL,
    nama character varying(255) NOT NULL,
    kelas_id bigint NOT NULL,
    user_id bigint,
    username character varying,
    password character varying,
    nis character varying(20),
    nisn character varying(20),
    jk character varying(1),
    tempat_lahir character varying(100),
    tgl_lahir date,
    nik character varying(20),
    agama character varying(20),
    alamat text,
    nama_ayah character varying(100),
    nama_ibu character varying(100)
);


ALTER TABLE public.siswas OWNER TO postgres;

--
-- Name: siswas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.siswas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.siswas_id_seq OWNER TO postgres;

--
-- Name: siswas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.siswas_id_seq OWNED BY public.siswas.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint,
    username character varying,
    password character varying,
    fullname character varying,
    "position" character varying,
    photo_url character varying,
    nip character varying,
    pangkat character varying,
    jabatan character varying,
    is_wali boolean,
    password_piket character varying
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: catatan_siswas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.catatan_siswas ALTER COLUMN id SET DEFAULT nextval('public.catatan_siswas_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: izins id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.izins ALTER COLUMN id SET DEFAULT nextval('public.izins_id_seq'::regclass);


--
-- Name: jadwals id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwals ALTER COLUMN id SET DEFAULT nextval('public.jadwals_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: jurnal_mengajars id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jurnal_mengajars ALTER COLUMN id SET DEFAULT nextval('public.jurnal_mengajars_id_seq'::regclass);


--
-- Name: jurnal_presensis id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jurnal_presensis ALTER COLUMN id SET DEFAULT nextval('public.jurnal_presensis_id_seq'::regclass);


--
-- Name: kelas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kelas ALTER COLUMN id SET DEFAULT nextval('public.kelas_id_seq'::regclass);


--
-- Name: mapels id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mapels ALTER COLUMN id SET DEFAULT nextval('public.mapels_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: orangtuas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orangtuas ALTER COLUMN id SET DEFAULT nextval('public.orangtuas_id_seq'::regclass);


--
-- Name: penilaians id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.penilaians ALTER COLUMN id SET DEFAULT nextval('public.penilaians_id_seq'::regclass);


--
-- Name: presensis id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.presensis ALTER COLUMN id SET DEFAULT nextval('public.presensis_id_seq'::regclass);


--
-- Name: qr_sessions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qr_sessions ALTER COLUMN id SET DEFAULT nextval('public.qr_sessions_id_seq'::regclass);


--
-- Name: siswas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.siswas ALTER COLUMN id SET DEFAULT nextval('public.siswas_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: catatan_siswas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.catatan_siswas (id, guru_id, siswa_id, judul, isi, kategori, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: izins; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.izins (id, siswa_id, tanggal, alasan, status, tipe, petugas_piket, approved_by, bukti, latitude, longitude) FROM stdin;
1	613	2026-04-27	sakitt (Input oleh Ortu)	reject	Sakit	\N	\N	storage/bukti_izin/1777270952_3419.jpg	-7.7132442	110.0315793
5	410	2026-04-27	pergi jalan-jalan (Input oleh Ortu)	approve	Izin	Edi Dwi Agus Rijanto, S.Pd.	11	storage/bukti_izin/1777272207_3529.jpg	-7.7132493	110.0315808
2	613	2026-04-27	Sakit (Input oleh Ortu)	reject	Izin	\N	\N	storage/bukti_izin/1777271451_3419.jpg	-7.7656643	109.8733573
3	613	2026-04-27	tamasya (Input oleh Ortu)	reject	Izin	\N	\N	storage/bukti_izin/1777271690_3419.jpg	-7.7623242	110.0309672
4	613	2026-04-27	peegi tamasya (Input oleh Ortu)	reject	Izin	\N	\N	storage/bukti_izin/1777271841_3419.jpg	-7.7623274	110.0309703
6	613	2026-04-27	pergi ke rumah daudara (Input oleh Ortu)	reject	Izin	\N	\N	storage/bukti_izin/1777272222_3419.jpg	-7.7623267	110.0309612
7	638	2026-04-27	sakett (Input oleh Ortu)	approve	Sakit	Ardi Setiyono, S.Pd.	5	storage/bukti_izin/1777277406_3300.jpg	-7.7132422	110.0315854
8	46	2026-06-20	Puskesmas	approve	Keluar Sekolah	Slamet, S.Pd	32	\N	\N	\N
\.


--
-- Data for Name: jadwals; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jadwals (id, user_id, hari, jam_mulai, jam_selesai, mata_pelajaran, kelas, semester) FROM stdin;
1	11	Senin	2	7	Instalasi Tenaga Listrik	11 TITL 2	20251
2	19	Selasa	6	7	Bahasa Inggris	11 TITL 3	20251
3	19	Senin	4	5	Bahasa Inggris	11 AKL 1	20251
4	19	Senin	6	7	Bahasa Inggris	11 TB 2	20251
5	19	Selasa	1	2	Bahasa Inggris	11 TITL 2	20251
6	32	Senin	6	7	Pendidikan Pancasila	11 AKL 1	20251
7	32	Senin	4	5	Pendidikan Pancasila	12 TITL 2	20251
8	32	Senin	8	9	Pendidikan Pancasila	11 TB 2	20251
9	32	Senin	8	9	Pendidikan Pancasila	11 TITL 2	20251
10	17	Senin	2	3	Pendidikan Agama Islam	12 TITL 2	20251
11	17	Senin	5	6	Pendidikan Agama Islam	12 AKL 2	20251
12	17	Senin	6	7	Pendidikan Agama Islam	12 TB 2	20251
13	31	Senin	2	3	Bahasa Jawa	12 TB 2	20251
14	31	Senin	4	5	Bahasa Jawa	11 TITL 3	20251
15	31	Senin	6	7	Bahasa Jawa	11 AKL 1	20251
16	31	Senin	8	9	Bahasa Jawa	10 AKL 2	20251
17	31	Rabu	9	10	Bahasa Jawa	10 TITL 3	20251
18	26	Senin	2	4	Matematika	12 AKL 2	20251
19	26	Senin	9	11	Matematika	11 TITL 3	20251
20	18	Senin	6	7	Bahasa Inggris	10 AKL 1	20251
21	18	Senin	6	7	Bahasa Inggris	12 TITL 2	20251
22	18	Senin	10	11	Bahasa Inggris	10 AKL 2	20251
23	5	Senin	2	5	Pendidikan Jasmani, Olahraga, dan Kesehatan	10 AKL 1	20251
24	36	Senin	2	7	Instalasi Motor Listrik	12 TITL 1	20251
25	36	Senin	8	11	Mata Pelajaran Pilihan	12 TITL 1	20251
26	34	Senin	4	6	Pembuatan Hiasan Busana	11 TB 1	20251
27	34	Senin	7	11	Projek Kreatif dan Kewirausahaan	11 TB 1	20251
28	35	Senin	2	7	Dasar-dasar Program Keahlian	10 TB 1	20251
29	8	Jumat	1	6	Dasar-dasar Program Keahlian	10 TITL 1	20251
30	14	Senin	8	11	Mata Pelajaran Pilihan	11 TITL 1	20251
31	9	Senin	2	3	Matematika	10 TITL 3	20251
32	9	Senin	4	5	Matematika	10 AKL 2	20251
33	22	Senin	6	9	Projek Ilmu Pengetahuan Alam dan Sosial	10 TITL 3	20251
34	22	Senin	8	11	Projek Ilmu Pengetahuan Alam dan Sosial	10 TITL 2	20251
35	16	Senin	8	11	Projek Ilmu Pengetahuan Alam dan Sosial	10 TB 2	20251
36	16	Senin	6	7	Sejarah	10 TITL 2	20251
37	16	Senin	8	9	Sejarah	10 TITL 3	20251
38	16	Senin	4	7	Projek Ilmu Pengetahuan Alam dan Sosial	10 TB 1	20251
39	15	Senin	4	5	Koding dan Kecerdasan Artifisial	10 AKL 2	20251
40	7	Senin	2	7	Dasar-dasar Program Keahlian	10 TB 2	20251
41	38	Senin	8	11	Dasar-dasar Program Keahlian	10 AKL 1	20251
42	41	Senin	8	11	Mata Pelajaran Pilihan	12 TITL 2	20251
43	30	Senin	2	7	Instalasi Penerangan Listrik	11 TITL 1	20251
44	42	Senin	2	7	Pembuatan Busana Custom Made	12 TB 1	20251
45	28	Senin	2	5	Mata Pelajaran Pilihan	11 TB 2	20251
46	28	Senin	6	11	Pembuatan Busana Industri	12 TB 1	20251
47	21	Senin	2	3	Desain Busana	11 TB 1	20251
48	21	Senin	4	9	Pembuatan Busana Custom Made	12 TB 2	20251
49	7	Senin	10	11	Desain Busana	11 TB 2	20251
50	33	Senin	2	7	Akuntansi Keuangan	11 AKL 2	20251
51	25	Senin	2	5	Komputer Akuntansi	11 AKL 2	20251
52	25	Senin	8	11	Praktikum Akuntansi Perusahaan Jasa, Dagang dan Manufaktur	11 AKL 1	20251
53	45	Selasa	1	1	Bimbingan dan Konseling	10 TITL 2	20251
54	45	Senin	9	9	Bimbingan dan Konseling	10 TITL 1	20251
55	13	Selasa	1	7	Praktikum Akuntansi Perusahaan Jasa, Dagang dan Manufaktur	12 AKL 1	20251
56	6	Senin	5	6	Pendidikan Pancasila	10 TITL 1	20251
57	6	Senin	10	11	Pendidikan Pancasila	10 TITL 3	20251
58	6	Senin	6	7	Pendidikan Pancasila	10 AKL 2	20251
59	6	Senin	8	9	Pendidikan Pancasila	10 TB 1	20251
60	6	Senin	10	11	Pendidikan Pancasila	10 AKL 1	20251
61	43	Senin	2	3	Bahasa Indonesia	10 AKL 2	20251
62	43	Senin	4	6	Bahasa Indonesia	11 TITL 3	20251
63	11	Selasa	1	6	Instalasi Tenaga Listrik	11 TITL 1	20251
64	4	Selasa	1	3	Pendidikan Agama Islam	10 TITL 1	20251
65	4	Rabu	4	6	Pendidikan Agama Islam	10 TB 2	20251
66	4	Rabu	1	3	Pendidikan Agama Islam	11 TITL 1	20251
67	20	Selasa	2	5	Bahasa Indonesia	11 TITL 2	20251
68	20	Rabu	4	3	Bahasa Indonesia	10 TITL 1	20251
69	20	Kamis	3	5	Bahasa Indonesia	12 AKL 1	20251
70	2	Selasa	3	3	Bimbingan dan Konseling	12 TB 1	20251
71	24	Selasa	4	6	Bahasa Indonesia	10 TB 2	20251
72	24	Selasa	2	4	Bahasa Indonesia	10 TB 1	20251
73	29	Selasa	3	5	Bahasa Indonesia	12 TB 2	20251
74	29	Selasa	6	8	Bahasa Indonesia	12 TITL 2	20251
75	32	Selasa	1	2	Pendidikan Pancasila	12 TB 2	20251
76	32	Selasa	9	10	Pendidikan Pancasila	12 AKL 2	20251
77	40	Selasa	1	2	Sejarah	10 AKL 1	20251
78	40	Selasa	5	6	Seni Budaya	10 AKL 2	20251
79	40	Senin	8	9	Seni Budaya	10 TB 1	20251
80	40	Selasa	8	9	Seni Budaya	10 TITL 1	20251
81	17	Selasa	1	3	Pendidikan Agama Islam	11 TB 1	20251
82	17	Selasa	9	11	Pendidikan Agama Islam	11 TB 2	20251
83	31	Senin	6	7	Bahasa Jawa	12 TITL 1	20251
84	31	Senin	10	11	Bahasa Jawa	11 TITL 2	20251
85	31	Selasa	7	8	Bahasa Jawa	11 AKL 2	20251
86	31	Senin	4	5	Bahasa Jawa	12 TITL 2	20251
87	26	Selasa	2	5	Matematika	12 AKL 1	20251
88	9	Selasa	6	8	Matematika	12 TB 2	20251
89	26	Selasa	9	11	Matematika	11 AKL 2	20251
90	18	Selasa	1	2	Bahasa Inggris	12 AKL 2	20251
91	18	Senin	4	5	Bahasa Inggris	12 TITL 1	20251
92	18	Selasa	7	8	Bahasa Inggris	10 AKL 1	20251
93	18	Senin	8	9	Bahasa Inggris	12 AKL 1	20251
94	5	Selasa	1	3	Pendidikan Jasmani, Olahraga, dan Kesehatan	10 TITL 3	20251
95	5	Selasa	4	6	Pendidikan Jasmani, Olahraga, dan Kesehatan	10 AKL 1	20251
96	36	Selasa	1	4	Mata Pelajaran Pilihan	11 TITL 3	20251
97	34	Selasa	2	5	Mata Pelajaran Pilihan	12 TB 1	20251
98	34	Senin	2	5	Projek Kreatif dan Kewirausahaan	12 TB 1	20251
99	35	Senin	4	11	Pembuatan Busana Custom Made	11 TB 1	20251
100	10	Senin	2	3	Sejarah	10 TITL 3	20251
101	10	Selasa	5	6	Sejarah	11 AKL 1	20251
102	8	Senin	6	11	Dasar-dasar Program Keahlian	10 TITL 2	20251
103	14	Selasa	7	11	Dasar-dasar Program Keahlian	10 TITL 3	20251
104	22	Selasa	3	4	Projek Ilmu Pengetahuan Alam dan Sosial	10 TITL 2	20251
105	22	Senin	10	11	Projek Ilmu Pengetahuan Alam dan Sosial	10 TITL 1	20251
106	16	Selasa	1	4	Projek Ilmu Pengetahuan Alam dan Sosial	10 TB 1	20251
107	16	Selasa	8	9	Projek Ilmu Pengetahuan Alam dan Sosial	10 TB 2	20251
108	16	Selasa	6	7	Sejarah	10 TITL 1	20251
109	15	Selasa	1	4	Informatika	10 AKL 2	20251
110	15	Senin	7	11	Projek Kreatif dan Kewirausahaan	11 TITL 3	20251
111	7	Selasa	1	8	Pembuatan Busana Custom Made	11 TB 2	20251
112	38	Selasa	7	11	Projek Kreatif dan Kewirausahaan	11 AKL 1	20251
113	27	Selasa	1	4	Mata Pelajaran Pilihan	11 AKL 1	20251
114	41	Selasa	6	11	Instalasi Motor Listrik	11 TITL 2	20251
115	23	Selasa	1	5	Projek Kreatif dan Kewirausahaan	12 TITL 2	20251
116	30	Selasa	5	10	Instalasi Penerangan Listrik	12 TITL 1	20251
117	45	Senin	5	5	Bimbingan dan Konseling	10 AKL 1	20251
118	45	Selasa	3	3	Bimbingan dan Konseling	10 TITL 3	20251
119	45	Selasa	5	5	Bimbingan dan Konseling	10 TB 1	20251
120	13	Rabu	1	4	Praktikum Akuntansi Perusahaan Jasa, Dagang dan Manufaktur	11 AKL 2	20251
121	13	Kamis	1	4	Dasar-dasar Program Keahlian	10 AKL 2	20251
122	37	Selasa	1	2	Bahasa Inggris	10 TB 2	20251
123	37	Selasa	5	6	Bahasa Inggris	10 TITL 3	20251
124	37	Senin	2	3	Bahasa Inggris	10 TB 1	20251
125	37	Senin	4	5	Bahasa Inggris	12 TB 2	20251
126	6	Selasa	1	2	Pendidikan Pancasila	10 TITL 2	20251
127	6	Senin	2	3	Pendidikan Pancasila	11 TITL 3	20251
128	6	Selasa	7	8	Sejarah	11 TITL 1	20251
129	6	Selasa	10	11	Pendidikan Pancasila	10 TB 2	20251
130	12	Kamis	11	12	Akuntansi Keuangan	12 AKL 1	20251
131	12	Senin	6	11	Komputer Akuntansi	12 AKL 2	20251
132	12	Kamis	7	8	Dasar-dasar Program Keahlian	10 AKL 1	20251
133	11	Rabu	1	6	Instalasi Tenaga Listrik	12 TITL 2	20251
134	4	Selasa	5	7	Pendidikan Agama Islam	10 AKL 2	20251
135	4	Rabu	5	7	Pendidikan Agama Islam	11 TITL 2	20251
136	4	Senin	2	4	Pendidikan Agama Islam	10 AKL 1	20251
137	20	Kamis	6	8	Bahasa Indonesia	11 AKL 2	20251
138	20	Kamis	1	2	Bahasa Indonesia	10 TITL 2	20251
139	19	Rabu	3	4	Bahasa Inggris	11 TITL 3	20251
140	19	Rabu	7	8	Bahasa Inggris	11 AKL 2	20251
141	19	Kamis	1	2	Bahasa Inggris	11 TITL 1	20251
142	19	Kamis	11	12	Bahasa Inggris	11 TITL 2	20251
143	2	Rabu	1	1	Bimbingan dan Konseling	12 TB 2	20251
144	2	Rabu	5	6	Bimbingan dan Konseling	12 AKL 2	20251
145	2	Selasa	4	4	Bimbingan dan Konseling	12 TITL 1	20251
146	2	Selasa	5	6	Bimbingan dan Konseling	12 TITL 2	20251
147	24	Kamis	4	6	Bahasa Indonesia	10 AKL 1	20251
148	24	Kamis	2	4	Bahasa Indonesia	10 TB 2	20251
149	29	Rabu	1	3	Bahasa Indonesia	11 TB 1	20251
150	29	Rabu	6	8	Bahasa Indonesia	11 AKL 1	20251
151	32	Rabu	4	5	Pendidikan Pancasila	11 TB 1	20251
152	32	Senin	10	11	Pendidikan Pancasila	11 AKL 2	20251
153	84	Rabu	3	4	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 TITL 2	20251
154	40	Rabu	3	4	Sejarah	10 TB 1	20251
155	40	Rabu	5	6	Seni Budaya	10 TITL 2	20251
156	40	Rabu	7	8	Seni Budaya	10 TITL 3	20251
157	40	Rabu	9	10	Seni Budaya	10 TB 2	20251
158	17	Senin	10	11	Pendidikan Agama Islam	12 AKL 1	20251
159	17	Senin	2	3	Pendidikan Agama Islam	12 TITL 1	20251
160	17	Rabu	6	8	Pendidikan Agama Islam	11 AKL 2	20251
161	17	Rabu	9	11	Pendidikan Agama Islam	12 TB 1	20251
162	31	Rabu	1	2	Bahasa Jawa	10 TB 1	20251
163	31	Rabu	7	8	Bahasa Jawa	10 TB 2	20251
164	9	Rabu	2	4	Matematika	10 TB 2	20251
165	9	Senin	10	11	Matematika	10 TB 1	20251
166	9	Rabu	8	10	Matematika	11 TITL 1	20251
167	26	Rabu	3	5	Matematika	11 AKL 1	20251
168	26	Rabu	8	10	Matematika	12 TITL 2	20251
169	18	Rabu	1	2	Bahasa Inggris	12 TITL 1	20251
170	18	Rabu	3	4	Bahasa Inggris	12 AKL 1	20251
171	18	Rabu	5	6	Bahasa Inggris	12 AKL 2	20251
172	18	Rabu	9	10	Bahasa Inggris	10 AKL 2	20251
173	5	Senin	2	4	Pendidikan Jasmani, Olahraga, dan Kesehatan	10 TITL 1	20251
174	5	Rabu	4	6	Pendidikan Jasmani, Olahraga, dan Kesehatan	10 AKL 2	20251
175	34	Senin	8	11	Mata Pelajaran Pilihan	12 TB 2	20251
176	34	Rabu	6	10	Projek Kreatif dan Kewirausahaan	12 TB 2	20251
177	35	Rabu	6	10	Pembuatan Busana Industri	11 TB 1	20251
178	10	Rabu	4	5	Sejarah	11 TB 2	20251
179	10	Rabu	7	10	Informatika	10 TB 1	20251
180	14	Rabu	1	5	Projek Kreatif dan Kewirausahaan	11 TITL 1	20251
181	14	Rabu	6	10	Dasar-dasar Program Keahlian	10 TITL 1	20251
182	22	Rabu	1	4	Projek Ilmu Pengetahuan Alam dan Sosial	10 TITL 3	20251
183	9	Senin	4	5	Matematika	10 TITL 3	20251
184	16	Rabu	1	2	Projek Ilmu Pengetahuan Alam dan Sosial	10 AKL 1	20251
185	16	Rabu	6	8	Projek Ilmu Pengetahuan Alam dan Sosial	10 AKL 2	20251
186	38	Rabu	1	2	Praktikum Akuntansi Lembaga/Instansi Pemerintah	11 AKL 1	20251
187	38	Rabu	5	7	Dasar-dasar Program Keahlian	10 AKL 1	20251
188	27	Senin	2	3	Administrasi Pajak	11 AKL 1	20251
189	41	Rabu	5	10	Instalasi Motor Listrik	11 TITL 3	20251
190	23	Senin	2	5	Informatika	10 TITL 2	20251
191	23	Rabu	6	10	Projek Kreatif dan Kewirausahaan	12 TITL 1	20251
192	42	Rabu	3	3	Pembuatan Hiasan Busana	11 TB 2	20251
193	28	Rabu	1	6	Pembuatan Busana Industri	12 TB 1	20251
194	21	Rabu	5	10	Projek Kreatif dan Kewirausahaan	11 TB 2	20251
195	13	Selasa	8	10	Administrasi Pajak	12 AKL 2	20251
196	13	Jumat	1	4	Mata Pelajaran Pilihan	12 AKL 2	20251
197	37	Rabu	1	2	Bahasa Inggris	10 TB 2	20251
198	37	Rabu	4	5	Bahasa Inggris	10 TITL 1	20251
199	37	Rabu	7	8	Bahasa Inggris	12 TB 1	20251
200	37	Rabu	9	10	Bahasa Inggris	10 TITL 2	20251
201	6	Rabu	1	2	Sejarah	11 TITL 2	20251
202	6	Rabu	3	4	Sejarah	11 TITL 3	20251
203	12	Rabu	5	10	Komputer Akuntansi	12 AKL 1	20251
204	3	Rabu	8	8	Bimbingan dan Konseling	11 TITL 2	20251
205	11	Kamis	1	6	Instalasi Tenaga Listrik	12 TITL 1	20251
206	4	Kamis	10	12	Pendidikan Agama Islam	11 TITL 3	20251
207	4	Jumat	4	6	Pendidikan Agama Islam	10 TITL 2	20251
208	4	Selasa	9	11	Pendidikan Agama Islam	10 TITL 3	20251
209	20	Kamis	1	3	Bahasa Indonesia	12 TITL 2	20251
210	20	Rabu	6	8	Bahasa Indonesia	11 TITL 1	20251
211	19	Rabu	1	2	Bahasa Inggris	11 AKL 1	20251
212	19	Jumat	1	2	Bahasa Inggris	11 TB 1	20251
213	19	Kamis	4	5	Bahasa Inggris	11 TB 2	20251
214	19	Senin	8	9	Bahasa Indonesia	11 AKL 2	20251
215	19	Rabu	9	10	Bahasa Inggris	11 TITL 1	20251
216	24	Rabu	3	4	Bahasa Indonesia	10 TB 1	20251
217	24	Rabu	5	6	Bahasa Indonesia	10 AKL 1	20251
218	32	Kamis	1	2	Pendidikan Pancasila	12 TB 1	20251
219	32	Kamis	3	4	Pendidikan Pancasila	11 TITL 1	20251
220	32	Kamis	7	8	Pendidikan Pancasila	12 TITL 1	20251
221	32	Senin	2	3	Pendidikan Pancasila	12 AKL 1	20251
222	39	Kamis	1	2	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 AKL 2	20251
223	39	Kamis	3	5	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 TITL 3	20251
224	40	Kamis	1	2	Seni Budaya	10 TB 2	20251
225	40	Kamis	9	10	Bahasa Jawa	10 TITL 1	20251
226	31	Senin	8	9	Bahasa Jawa	11 TB 2	20251
227	31	Kamis	3	4	Bahasa Jawa	12 TB 1	20251
228	31	Kamis	5	6	Bahasa Jawa	12 AKL 1	20251
229	31	Kamis	7	8	Bahasa Jawa	10 AKL 1	20251
230	31	Kamis	9	10	Bahasa Jawa	11 TITL 1	20251
231	9	Kamis	1	3	Matematika	11 TITL 2	20251
232	9	Kamis	5	6	Matematika	10 TB 1	20251
233	9	Kamis	6	8	Matematika	10 TB 2	20251
234	5	Kamis	1	2	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 TITL 1	20251
235	5	Kamis	3	4	Pendidikan Jasmani, Olahraga, dan Kesehatan	10 TB 2	20251
236	36	Senin	6	11	Instalasi Motor Listrik	12 TITL 2	20251
237	35	Kamis	7	12	Dasar-dasar Program Keahlian	10 TB 1	20251
238	22	Senin	2	3	Sejarah	11 TB 1	20251
239	10	Kamis	5	8	Informatika	10 TITL 1	20251
240	10	Kamis	9	12	Informatika	10 TB 2	20251
241	14	Kamis	4	7	Mata Pelajaran Pilihan	11 TITL 2	20251
242	14	Kamis	8	12	Dasar-dasar Program Keahlian	10 TITL 2	20251
243	22	Kamis	1	4	Projek Ilmu Pengetahuan Alam dan Sosial	10 TITL 1	20251
244	9	Kamis	11	12	Matematika	10 AKL 2	20251
325	20	Rabu	3	5	Bahasa Indonesia	12 AKL 2	20251
245	16	Kamis	5	8	Projek Ilmu Pengetahuan Alam dan Sosial	10 AKL 2	20251
246	16	Kamis	9	10	Sejarah	10 AKL 2	20251
247	15	Kamis	1	4	Informatika	10 AKL 1	20251
248	15	Kamis	8	12	Projek Kreatif dan Kewirausahaan	11 TITL 2	20251
249	7	Kamis	8	12	Pembuatan Busana Industri	11 TB 2	20251
250	38	Senin	4	7	Mata Pelajaran Pilihan	12 AKL 1	20251
251	38	Kamis	7	8	Praktikum Akuntansi Lembaga/Instansi Pemerintah	11 AKL 2	20251
252	27	Kamis	3	6	Mata Pelajaran Pilihan	11 AKL 2	20251
253	27	Kamis	11	12	Administrasi Pajak	11 AKL 2	20251
254	41	Senin	8	11	Mata Pelajaran Pilihan	12 TITL 1	20251
255	23	Kamis	1	7	Dasar-dasar Program Keahlian	10 TITL 3	20251
256	30	Kamis	1	6	Instalasi Penerangan Listrik	12 TITL 2	20251
257	30	Kamis	7	12	Instalasi Penerangan Listrik	11 TITL 3	20251
258	42	Kamis	6	12	Pembuatan Busana Custom Made	12 TB 1	20251
259	28	Kamis	7	10	Pembuatan Busana Industri	12 TB 2	20251
260	21	Kamis	1	6	Pembuatan Busana Custom Made	12 TB 2	20251
261	21	Kamis	9	12	Mata Pelajaran Pilihan	11 TB 1	20251
262	33	Jumat	1	6	Akuntansi Keuangan	11 AKL 1	20251
263	25	Kamis	3	6	Komputer Akuntansi	11 AKL 1	20251
264	45	Rabu	1	1	Bimbingan dan Konseling	10 AKL 2	20251
265	45	Selasa	9	9	Bimbingan dan Konseling	10 TB 2	20251
266	13	Kamis	6	12	Praktikum Akuntansi Perusahaan Jasa, Dagang dan Manufaktur	12 AKL 2	20251
267	37	Kamis	1	2	Bahasa Indonesia	10 TB 1	20251
268	37	Kamis	3	4	Bahasa Inggris	10 TITL 2	20251
269	37	Kamis	5	6	Bahasa Inggris	12 TB 1	20251
270	37	Kamis	8	9	Bahasa Inggris	10 TITL 3	20251
271	37	Kamis	11	12	Bahasa Inggris	12 TB 2	20251
272	12	Kamis	2	3	Dasar-dasar Program Keahlian	10 AKL 2	20251
273	12	Rabu	7	10	Akuntansi Keuangan	12 AKL 1	20251
274	12	Senin	2	5	Akuntansi Keuangan	12 AKL 2	20251
275	3	Kamis	5	5	Bimbingan dan Konseling	11 TB 1	20251
276	3	Kamis	6	6	Bimbingan dan Konseling	11 TITL 3	20251
277	3	Kamis	8	8	Bimbingan dan Konseling	11 TITL 1	20251
278	44	Kamis	1	2	Matematika	10 TITL 2	20251
279	44	Kamis	3	5	Matematika	11 TB 2	20251
280	44	Kamis	5	8	Matematika	11 TB 1	20251
281	44	Kamis	9	10	Matematika	10 AKL 1	20251
282	44	Kamis	11	12	Matematika	10 TITL 1	20251
283	11	Jumat	1	6	Instalasi Tenaga Listrik	11 TITL 3	20251
284	4	Kamis	6	8	Pendidikan Agama Islam	10 TB 1	20251
285	20	Jumat	1	2	Bahasa Indonesia	10 TITL 3	20251
286	20	Senin	7	8	Bahasa Indonesia	10 TITL 1	20251
287	20	Selasa	5	7	Bahasa Indonesia	10 TITL 2	20251
288	19	Kamis	7	8	Bahasa Inggris	11 TB 1	20251
289	2	Rabu	4	4	Bimbingan dan Konseling	12 AKL 1	20251
290	29	Jumat	1	3	Bahasa Indonesia	12 TITL 1	20251
291	29	Jumat	4	6	Bahasa Indonesia	12 TB 1	20251
292	39	Jumat	1	2	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 TB 2	20251
293	39	Jumat	3	4	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 TB 1	20251
294	40	Jumat	1	2	Bahasa Jawa	10 TITL 2	20251
295	17	Jumat	1	3	Pendidikan Agama Islam	11 AKL 1	20251
296	31	Jumat	1	2	Bahasa Jawa	11 TB 1	20251
297	31	Jumat	5	6	Bahasa Jawa	12 AKL 2	20251
298	9	Jumat	1	3	Matematika	12 TB 1	20251
299	26	Jumat	4	6	Matematika	12 TITL 1	20251
300	18	Senin	2	3	Bahasa Inggris	12 TITL 2	20251
301	5	Jumat	1	3	Pendidikan Jasmani, Olahraga, dan Kesehatan	10 TB 1	20251
302	5	Jumat	4	5	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 AKL 1	20251
303	36	Jumat	3	6	Perbaikan Peralatan Listrik	12 TITL 2	20251
304	16	Jumat	1	4	Projek Ilmu Pengetahuan Alam dan Sosial	10 AKL 1	20251
305	15	Jumat	2	6	Projek Kreatif dan Kewirausahaan	12 AKL 1	20251
306	7	Jumat	1	6	Dasar-dasar Program Keahlian	10 TB 2	20251
307	38	Jumat	2	6	Projek Kreatif dan Kewirausahaan	11 AKL 2	20251
308	41	Jumat	1	6	Instalasi Motor Listrik	11 TITL 1	20251
309	23	Jumat	3	6	Informatika	10 TITL 3	20251
310	30	Jumat	1	6	Instalasi Penerangan Listrik	11 TITL 2	20251
311	28	Jumat	1	6	Pembuatan Busana Industri	12 TB 2	20251
312	13	Senin	6	9	Dasar-dasar Program Keahlian	10 AKL 2	20251
313	37	Jumat	5	6	Bahasa Inggris	10 TITL 1	20251
314	12	Selasa	1	2	Akuntansi Keuangan	12 AKL 2	20251
315	3	Jumat	1	1	Bimbingan dan Konseling	11 AKL 2	20251
316	3	Jumat	3	3	Bimbingan dan Konseling	11 TB 2	20251
317	3	Jumat	6	6	Bimbingan dan Konseling	11 AKL 1	20251
318	43	Jumat	5	6	Bahasa Indonesia	10 AKL 2	20251
319	43	Jumat	1	3	Bahasa Indonesia	11 TB 2	20251
320	44	Jumat	1	2	Matematika	10 TITL 1	20251
321	44	Jumat	3	4	Bahasa Indonesia	10 TITL 2	20251
322	44	Jumat	5	6	Matematika	10 AKL 1	20251
323	33	Kamis	1	5	Projek Kreatif dan Kewirausahaan	12 AKL 2	20251
324	12	Selasa	8	10	Administrasi Pajak	12 AKL 1	20251
326	20	Selasa	1	2	Bahasa Indonesia	10 AKL 1	20251
327	11	Senin	2	3	Instalasi Tenaga Listrik	11 TITL 1	20252
328	11	Senin	4	7	Instalasi Tenaga Listrik	11 TITL 2	20252
329	32	Senin	7	8	Pendidikan Pancasila	12 TITL 2	20252
330	32	Senin	10	11	Pendidikan Pancasila	11 TITL 2	20252
331	14	Senin	2	5	Dasar-dasar Program Keahlian	10 TITL 2	20252
332	14	Senin	7	11	Projek Kreatif dan Kewirausahaan	11 TITL 1	20252
333	5	Senin	2	4	Pendidikan Jasmani, Olahraga, dan Kesehatan	10 TITL 3	20252
334	19	Senin	2	3	Bahasa Inggris	11 TB 1	20252
335	19	Senin	6	7	Bahasa Inggris	11 AKL 1	20252
336	19	Senin	8	9	Bahasa Inggris	11 TITL 2	20252
337	26	Senin	2	4	Matematika	12 AKL 1	20252
338	8	Senin	6	11	Dasar-dasar Program Keahlian	10 TITL 1	20252
339	28	Senin	6	11	Pembuatan Busana Industri	12 TB 1	20252
340	30	Senin	6	11	Instalasi Penerangan Listrik	12 TITL 1	20252
341	42	Senin	9	11	Pembuatan Hiasan Busana	11 TB 2	20252
342	41	Senin	2	5	Mata Pelajaran Pilihan	12 TITL 1	20252
343	95	Senin	2	3	Matematika	10 TB 1	20252
344	95	Senin	4	6	Matematika	11 TITL 3	20252
345	95	Senin	8	9	Matematika	10 AKL 1	20252
346	31	Senin	2	3	Bahasa Jawa	11 TITL 2	20252
347	31	Senin	4	5	Bahasa Jawa	10 TB 1	20252
348	31	Senin	6	7	Bahasa Jawa	10 TB 2	20252
349	2	Senin	4	4	Bimbingan dan Konseling	12 TB 1	20252
350	2	Senin	9	9	Bimbingan dan Konseling	12 TITL 2	20252
351	7	Senin	8	11	Dasar-dasar Program Keahlian	10 TB 2	20252
352	13	Senin	2	5	Administrasi Pajak	11 AKL 2	20252
353	13	Senin	8	11	Dasar-dasar Program Keahlian	10 AKL 2	20252
354	34	Senin	2	5	Mata Pelajaran Pilihan	12 TB 1	20252
355	34	Senin	7	11	Projek Kreatif dan Kewirausahaan	10 AKL 1	20252
356	12	Senin	4	7	Akuntansi Keuangan	12 AKL 2	20252
357	12	Senin	8	11	Akuntansi Keuangan	12 AKL 1	20252
358	20	Senin	7	8	Bahasa Indonesia	10 TITL 3	20252
359	35	Senin	4	11	Pembuatan Busana Custom Made	11 TB 1	20252
360	37	Senin	2	3	Bahasa Inggris	12 TB 2	20252
361	37	Senin	4	5	Bahasa Inggris	10 TITL 1	20252
362	27	Senin	2	5	Mata Pelajaran Pilihan	11 AKL 1	20252
363	10	Senin	6	7	Koding dan Kecerdasan Artifisial	10 TITL 2	20252
364	43	Senin	9	11	Bahasa Indonesia	11 TITL 3	20252
365	38	Senin	4	7	Dasar-dasar Program Keahlian	10 AKL 1	20252
366	25	Senin	7	11	Komputer Akuntansi	11 AKL 1	20252
367	22	Senin	8	11	Projek Ilmu Pengetahuan Alam dan Sosial	10 TITL 2	20252
368	16	Senin	2	5	Projek Ilmu Pengetahuan Alam dan Sosial	10 TB 2	20252
369	16	Senin	6	7	Projek Ilmu Pengetahuan Alam dan Sosial	10 AKL 2	20252
370	16	Senin	8	11	Projek Ilmu Pengetahuan Alam dan Sosial	10 TB 1	20252
371	23	Senin	2	6	Projek Kreatif dan Kewirausahaan	12 TITL 2	20252
372	6	Senin	2	3	Pendidikan Pancasila	10 AKL 1	20252
373	6	Senin	4	5	Pendidikan Pancasila	10 TITL 3	20252
374	6	Senin	7	8	Pendidikan Pancasila	11 TITL 3	20252
375	15	Senin	2	5	Informatika	10 AKL 2	20252
376	3	Senin	6	6	Bimbingan dan Konseling	11 AKL 2	20252
377	40	Senin	2	3	Seni Budaya	10 TITL 1	20252
378	40	Senin	6	7	Sejarah	10 TB 1	20252
379	40	Senin	10	11	Seni Budaya	10 AKL 1	20252
380	39	Senin	2	3	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 TITL 3	20252
381	21	Senin	2	8	Projek Kreatif dan Kewirausahaan	11 TB 2	20252
382	4	Senin	4	6	Pendidikan Agama Islam	11 TITL 1	20252
383	4	Senin	9	11	Pendidikan Agama Islam	10 TITL 3	20252
384	97	Senin	5	7	Administrasi Pajak	12 AKL 1	20252
385	97	Senin	8	11	Mata Pelajaran Pilihan	12 AKL 2	20252
386	97	Senin	8	11	Mata Pelajaran Pilihan	12 AKL 2	20252
387	17	Senin	2	3	Pendidikan Agama Islam	12 AKL 2	20252
388	17	Senin	5	6	Pendidikan Agama Islam	12 TB 2	20252
389	17	Senin	7	9	Pendidikan Agama Islam	11 AKL 2	20252
390	17	Senin	10	11	Pendidikan Agama Islam	12 TITL 2	20252
391	11	Senin	3	5	Instalasi Tenaga Listrik	11 TITL 3	\N
392	11	Senin	5	7	Instalasi Tenaga Listrik	11 TITL 1	\N
393	5	Senin	1	2	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 AKL 1	\N
394	11	Senin	2	5	Instalasi Tenaga Listrik	11 TITL 3	\N
395	11	Senin	6	8	Instalasi Tenaga Listrik	12 TITL 2	\N
396	11	Senin	2	3	Instalasi Tenaga Listrik	12 TITL 1	\N
397	11	Senin	10	11	Instalasi Tenaga Listrik	11 TITL 1	\N
398	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
399	11	Senin	3	4	Instalasi Tenaga Listrik	11 TITL 1	\N
400	11	Senin	3	4	Instalasi Tenaga Listrik	11 TITL 1	\N
401	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
402	11	Senin	3	4	Instalasi Tenaga Listrik	11 TITL 1	\N
403	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
404	11	Senin	3	4	Instalasi Tenaga Listrik	11 TITL 1	\N
405	11	Senin	8	9	Instalasi Tenaga Listrik	11 TITL 1	\N
406	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
407	11	Senin	9	10	Instalasi Tenaga Listrik	11 TITL 1	\N
408	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
409	11	Senin	6	7	Instalasi Tenaga Listrik	11 TITL 1	\N
410	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
411	11	Senin	7	8	Instalasi Tenaga Listrik	11 TITL 1	\N
412	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
413	11	Senin	7	8	Instalasi Tenaga Listrik	11 TITL 1	\N
414	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
415	11	Senin	8	9	Instalasi Tenaga Listrik	11 TITL 1	\N
416	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
417	11	Senin	5	6	Instalasi Tenaga Listrik	11 TITL 1	\N
418	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
419	11	Senin	6	7	Instalasi Tenaga Listrik	11 TITL 1	\N
420	11	Senin	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
421	11	Senin	5	6	Instalasi Tenaga Listrik	11 TITL 1	\N
422	11	Senin	9	10	Instalasi Tenaga Listrik	11 TITL 2	\N
423	10	Selasa	1	2	Informatika	11 AKL 1	\N
424	32	Jumat	9	11	Pendidikan Pancasila	11 AKL 2	\N
425	32	Sabtu	1	2	Pendidikan Pancasila	11 AKL 2	\N
426	11	Minggu	1	2	Instalasi Tenaga Listrik	11 TITL 3	\N
427	32	Minggu	1	2	Pendidikan Pancasila	11 TITL 2	\N
428	11	Jumat	1	2	Instalasi Tenaga Listrik	11 TITL 1	\N
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: jurnal_mengajars; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jurnal_mengajars (id, user_id, tanggal, mata_pelajaran, kelas, jam_mulai, jam_selesai, ringkasan_materi, semester, created_at, updated_at, qr_session_id) FROM stdin;
34	11	2026-04-27	Instalasi Tenaga Listrik	11 TITL 1	5	6	coba	-	2026-04-27 15:51:26	2026-04-27 15:51:47	100
36	10	2026-05-12	Informatika	11 AKL 1	1	2	materi 1	-	2026-05-12 11:14:03	2026-05-12 11:14:17	102
37	32	2026-06-12	Pendidikan Pancasila	11 AKL 2	9	11		-	2026-06-12 16:07:14	2026-06-12 16:07:14	103
38	32	2026-06-20	Pendidikan Pancasila	11 AKL 2	1	2		-	2026-06-20 13:23:33	2026-06-20 13:23:33	104
39	11	2026-06-21	Instalasi Tenaga Listrik	11 TITL 3	1	2		-	2026-06-21 17:34:08	2026-06-21 17:34:08	105
40	32	2026-06-21	Pendidikan Pancasila	11 TITL 2	1	2		-	2026-06-21 17:53:12	2026-06-21 17:53:12	106
41	11	2026-06-26	Instalasi Tenaga Listrik	11 TITL 1	1	2	Pelajaran Baru21	20241	2026-06-26 10:28:47	2026-06-26 10:35:05	107
14	32	2026-04-27	Pendidikan Pancasila	12 AKL 1	2	3	mencoajcojod	20251	2026-04-27 08:31:24	2026-04-27 08:31:40	63
20	5	2026-04-27	Pendidikan Jasmani, Olahraga, dan Kesehatan	11 AKL 1	1	2	senam	-	2026-04-27 15:01:20	2026-04-27 15:01:25	72
\.


--
-- Data for Name: jurnal_presensis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jurnal_presensis (id, jurnal_id, nama_siswa, status, created_at, updated_at) FROM stdin;
962	14	Ardiansya Alifya Septya Nugroho	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
963	14	Asmaa Nur Kamilah	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
964	14	Deny Saputra	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
965	14	Erlin Ramadhani	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
966	14	Indah Puspitasari	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
967	14	Intan Nur Azizah	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
968	14	Lucky Handayani	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
969	14	Nova Sandria Zahra Nadhifa	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
970	14	Syafrida Yuliana	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
971	14	Attaya Qesya Putri	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
972	14	Dwi Astuti	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
973	14	Indri Syaharani	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
974	14	Lana Ulfa Azizah	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
975	14	Malika Dewi Septiana	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
976	14	Navila Agustin Setyowati	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
977	14	Tri Yuliana Ristiyanti	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
978	14	Abidzar Khansa Raihan	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
979	14	Adelia Nabila Chakim	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
980	14	Afiifah Dwi Oktaviani	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
981	14	Arina Ni'Matuzzakiah	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
982	14	Arini Nasywa Salshabila	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
983	14	Cindy Dwi Andany	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
984	14	Dea Nur Pratitis	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
985	14	Dila Aulia Puspaningrum	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
986	14	Ferlyta Dwi Hapsari	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
987	14	Fiani Wilujeng Raharjanti	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
988	14	Isna Laisya Yulianti	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
989	14	Lufki Tri Astuti	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
990	14	Medina Ayu Rahma	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
991	14	Muharromah Tri Handayani	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
992	14	Oktavia Rahmadani	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
993	14	Syafiatun Eka Nur Rukmana	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
994	14	Tegar Rukmana Saleh	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
995	14	Winda Auliandari	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
996	14	Yuliana Eka Saputri	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
997	14	Yulianita	Belum Absen	2026-04-27 08:31:40	2026-04-27 08:31:40
2060	20	Anaya Rasya Kania	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2061	20	Annisa Agustina	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2062	20	Azka Shofiana	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2063	20	Devina Rahayu	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2064	20	Fatkhur Akbar Pangestu	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2065	20	Helena Happy Lestari	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2066	20	Lu'Luul Maknunah	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2067	20	Pratista Conita Arwen	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2068	20	Rania Dwi Puspita	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2069	20	Shifa Nuril Fadhilah	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2070	20	Vina Nur Yanti	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2071	20	Adella Putri Hidayati Nurdin	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2072	20	Angger Lisnawati Derista Utami	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2073	20	Devina Nuraini	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2074	20	Fuji Suryaningsih	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2075	20	Isabitha Wulandari	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2076	20	Muhammad Rizqi Latif	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2077	20	Retno Wahyu Ningrum	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2078	20	Umi Latifah	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2079	20	Alexandria Barawati Mustika Putri	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2080	20	Ambar Setyaningrum	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2081	20	Aprilia Elvi Zahara	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2082	20	Azizah Nur Febriati	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2083	20	Deaundre Adriel Bayutama	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2084	20	Dimas Fahri Prakosa	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2085	20	Fadila Dwi Astuti	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2086	20	Hari Suswandaru Wirawan	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2087	20	Isnaini Rose Lestari	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2088	20	Laila Arcika Kurniasih	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2089	20	Miftahul Hasanah	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2090	20	Rahma Anjali Nareswari	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2091	20	Ramdhan Wahid Al Ahmad	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2092	20	Saras Yunita Putri	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2093	20	Sifa Yenita Lestari	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
2094	20	Syifa Ramadhita Hapsari	Belum Absen	2026-04-27 15:01:25	2026-04-27 15:01:25
5199	37	Alfina Juniana Sari	Terlambat	2026-06-12 16:10:16	2026-06-12 16:10:16
5200	37	Ika Nur Lutfiyah	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5201	37	Deviana Nur Latifah	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5202	37	Efrila Fika Putri	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5203	37	Julia Uswatun Khasanah	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5204	37	Linda Khairunisa	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5205	37	Nabila Nurul Maulida	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5206	37	Nevi Agoestina	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5207	37	Putri Nur Mudma'Inah	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5208	37	Rifka Rachel Ulima	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5209	37	Syaila Nayla Alifah	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5210	37	Tyrza Anastasya	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5211	37	Devina Meilani	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5212	37	Jesica Ayu Putri	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5213	37	Lita Adiya	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5214	37	Nur Hidayah Juliana	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5215	37	Ratri Dwi Oktarini	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5216	37	Wening Fajria Wigati	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5217	37	Syifa Lutfiana Jahra	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5218	37	Cera Arzika	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5219	37	Eka Duwik Prasetiyo	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5220	37	Fiandra Iqbal Maulana	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5221	37	Laila Naswa Jannah	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5222	37	Lare Prayudia Utami	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5223	37	Mao Nabila Bunga Cahyaningrum	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5224	37	Muhammad Fahrel Alansyah	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5225	37	Nailina Indah Pratiwi	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5226	37	Peny Pujiati	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5227	37	Poundra Praditya Daniswara	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5228	37	Rahayu Setianingsih	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5229	37	Salma Rahmania Kirom	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5230	37	Silvia Dyah Apriliani	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5231	37	Vina Maharani	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
4857	34	Habib Puja Prasetya	Izin	2026-04-27 15:51:47	2026-04-27 15:51:47
4858	34	Galang Yudho Wicaksono	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4859	34	Anang Kholilur Rohman	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4860	34	Epi Ndaru Candra Kartika	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4861	34	Farhan Alif Prasetyo	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4862	34	Hafiz Al Qorni	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4863	34	Mistades Aryano	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4864	34	Muhammad Rizki Yanto	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4865	34	Deby Bayu Pamungkas	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4866	34	Farid Yusuf Kurniawan	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4867	34	Muhammad Asyraf Sadewa	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4868	34	Abigail Khalil Maulana Achmad	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4869	34	Aditya Galang Pradita	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4870	34	Daffa Fadhlur Rohman	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4871	34	Darelleo Veda Alana	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4872	34	Eva Octavia	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4873	34	Fajar Nur Fauzan	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4874	34	Farkhan Hidayat	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4875	34	Keisa Rahmawati	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4876	34	Keyla Shiva Az Zahra	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4877	34	Muhammad Jallu Arif Prasetyo	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4878	34	Nafalsa Setyawan	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4879	34	Novita Fajar Ramadhani	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4880	34	Restu Prasetya	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4881	34	Restu Sulistyo Putra	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4882	34	Susanto Jaya	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4883	34	Tasyahara Putri Aryanda	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4884	34	Tiara Andjani Putri	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4885	34	Wisetya Aqila Febrian	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4886	34	Yanuar Dwi Setiawan	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4887	34	Zhafran Lingga Prathama	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4888	34	Zidan Fadhila Alfaiz	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
4889	34	Zuhrul Anam	Belum Absen	2026-04-27 15:51:47	2026-04-27 15:51:47
5232	37	Wiji Larasati Khoirunisa	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5233	37	Yeni Subekti	Belum Absen	2026-06-12 16:10:16	2026-06-12 16:10:16
5234	38	Ika Nur Lutfiyah	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5235	38	Deviana Nur Latifah	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5236	38	Efrila Fika Putri	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5237	38	Julia Uswatun Khasanah	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5238	38	Linda Khairunisa	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5239	38	Nabila Nurul Maulida	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5240	38	Nevi Agoestina	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5241	38	Putri Nur Mudma'Inah	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5242	38	Rifka Rachel Ulima	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5243	38	Syaila Nayla Alifah	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5244	38	Tyrza Anastasya	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5245	38	Devina Meilani	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5246	38	Jesica Ayu Putri	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5247	38	Lita Adiya	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5248	38	Nur Hidayah Juliana	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5249	38	Ratri Dwi Oktarini	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5250	38	Wening Fajria Wigati	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5251	38	Syifa Lutfiana Jahra	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5252	38	Alfina Juniana Sari	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5253	38	Cera Arzika	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5254	38	Eka Duwik Prasetiyo	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5255	38	Fiandra Iqbal Maulana	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5256	38	Laila Naswa Jannah	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5257	38	Lare Prayudia Utami	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5258	38	Mao Nabila Bunga Cahyaningrum	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5259	38	Muhammad Fahrel Alansyah	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5260	38	Nailina Indah Pratiwi	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5261	38	Peny Pujiati	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5262	38	Poundra Praditya Daniswara	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5263	38	Rahayu Setianingsih	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5264	38	Salma Rahmania Kirom	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5265	38	Silvia Dyah Apriliani	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5266	38	Vina Maharani	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5267	38	Wiji Larasati Khoirunisa	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5268	38	Yeni Subekti	Belum Absen	2026-06-20 13:23:33	2026-06-20 13:23:33
5269	39	Achmad Nuhalmustawi	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5270	39	Alifia Nadiatun	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5271	39	Arya Budi Pratama	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5272	39	Dhimas Osama	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5273	39	Ibnu Rizky Shobari	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5274	39	Iqmal Kurnia Riski	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5275	39	Muhammad Alwy Ahsan Fadlullah	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5276	39	Nasichatul Faricha	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5277	39	Rizki Ardiansyah	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5278	39	Sofyan Nur Fadhilah	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5279	39	Wildan Hadi Nugraha	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5280	39	Akbar Kurniawan	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5281	39	Cahyo Aji Nugraha	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5282	39	Eliya Masliha	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5283	39	Mario Adi Prasetyo	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5284	39	Najwa Zelvia Zahra	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5285	39	Slamet Eko Aprilianto	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5286	39	Yanuar Stya Nugroho	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5287	39	Ahmad Alfan Mubarok	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5288	39	Ananda Anugrahnanto	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5289	39	Andian Ma'Ruf	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5290	39	Dinda Rahmawati	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5291	39	Galih Praditya Dwi Saputro	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5292	39	Hendry Herlistyo	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5293	39	Muhamad Hanif Saputra	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5294	39	Muhammad Abdulrahman	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5295	39	Muhammad Farhan Zen Maulana	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5296	39	Natasya Raichana Putri	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5297	39	Revinja Isya Maulana	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5298	39	Setya Dharma Adi Nata	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5299	39	Suhgi Eka Ramdani	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5300	39	Wahyu Rohadi	Belum Absen	2026-06-21 17:34:08	2026-06-21 17:34:08
5301	40	Arsa Radhitiya	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5302	40	Damar Wisongko	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5303	40	Eca Kirana Putri	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5304	40	Galang Khoirul Ichsan	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5129	36	Azka Shofiana	Terlambat	2026-05-12 11:15:15	2026-05-12 11:15:15
5130	36	Anaya Rasya Kania	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5131	36	Annisa Agustina	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5132	36	Devina Rahayu	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5133	36	Fatkhur Akbar Pangestu	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5134	36	Helena Happy Lestari	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5135	36	Lu'Luul Maknunah	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5136	36	Pratista Conita Arwen	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5137	36	Rania Dwi Puspita	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5138	36	Shifa Nuril Fadhilah	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5139	36	Vina Nur Yanti	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5140	36	Adella Putri Hidayati Nurdin	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5141	36	Angger Lisnawati Derista Utami	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5142	36	Devina Nuraini	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5143	36	Fuji Suryaningsih	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5144	36	Isabitha Wulandari	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5145	36	Muhammad Rizqi Latif	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5146	36	Retno Wahyu Ningrum	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5147	36	Umi Latifah	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5148	36	Alexandria Barawati Mustika Putri	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5149	36	Ambar Setyaningrum	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5150	36	Aprilia Elvi Zahara	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5151	36	Azizah Nur Febriati	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5152	36	Deaundre Adriel Bayutama	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5153	36	Dimas Fahri Prakosa	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5154	36	Fadila Dwi Astuti	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5155	36	Hari Suswandaru Wirawan	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5156	36	Isnaini Rose Lestari	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5157	36	Laila Arcika Kurniasih	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5158	36	Miftahul Hasanah	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5159	36	Rahma Anjali Nareswari	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5160	36	Ramdhan Wahid Al Ahmad	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5161	36	Saras Yunita Putri	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5162	36	Sifa Yenita Lestari	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5163	36	Syifa Ramadhita Hapsari	Belum Absen	2026-05-12 11:15:15	2026-05-12 11:15:15
5305	40	Galang Satria Utama	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5306	40	Ikhsan Pratama	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5307	40	Inggo Manna Azaro	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5308	40	Mario Cahyo Anggoro	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5309	40	Muhamad Aldan Hanif	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5310	40	Muhammad Anwar	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5311	40	Narindra Budi Pratama	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5312	40	Rayhan Awalian Nurohman	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5313	40	Saiful Abyan	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5314	40	Arza Rayhan Ramadhan	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5315	40	Dwi Alfianto	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5316	40	Farkhan Maulana Saputra	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5317	40	Ibram Mahya Adim	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5318	40	Jibran Pandu Pratama	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5319	40	Mohamad Hafiz Silmi Nur Fadhil	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5320	40	Muhammad Januar Setiawan	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5321	40	Nur Dzakiyah Qurrotu Aini	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5322	40	Syarif Hidayatulloh	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5323	40	Adelia Listy Nugraha	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5324	40	Ahmad Nafi' Junaidi	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5325	40	Ahmad Syabban Zakiyyan	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5326	40	Alhafit Evan Ramdani	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5327	40	Anandita Vega	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5328	40	Ardiansyah Suhartono	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5329	40	Raditya Dimas Maulana	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5330	40	Rian Ardiyanto	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5331	40	Ridho Praditya Putra	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5332	40	Triyono	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5333	40	Wahyu Budi Prakoso	Belum Absen	2026-06-21 17:53:12	2026-06-21 17:53:12
5566	41	Galang Yudho Wicaksono	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5567	41	Anang Kholilur Rohman	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5568	41	Epi Ndaru Candra Kartika	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5569	41	Farhan Alif Prasetyo	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5570	41	Hafiz Al Qorni	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5571	41	Mistades Aryano	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5572	41	Muhammad Rizki Yanto	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5573	41	Deby Bayu Pamungkas	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5574	41	Farid Yusuf Kurniawan	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5575	41	Habib Puja Prasetya	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5576	41	Muhammad Asyraf Sadewa	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5577	41	Abigail Khalil Maulana Achmad	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5578	41	Aditya Galang Pradita	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5579	41	Daffa Fadhlur Rohman	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5580	41	Darelleo Veda Alana	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5581	41	Eva Octavia	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5582	41	Fajar Nur Fauzan	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5583	41	Farkhan Hidayat	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5584	41	Keisa Rahmawati	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5585	41	Keyla Shiva Az Zahra	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5586	41	Muhammad Jallu Arif Prasetyo	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5587	41	Nafalsa Setyawan	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5588	41	Novita Fajar Ramadhani	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5589	41	Restu Prasetya	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5590	41	Restu Sulistyo Putra	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5591	41	Susanto Jaya	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5592	41	Tasyahara Putri Aryanda	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5593	41	Tiara Andjani Putri	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5594	41	Wisetya Aqila Febrian	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5595	41	Yanuar Dwi Setiawan	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5596	41	Zhafran Lingga Prathama	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5597	41	Zidan Fadhila Alfaiz	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
5598	41	Zuhrul Anam	Belum Absen	2026-06-26 10:40:16	2026-06-26 10:40:16
\.


--
-- Data for Name: kelas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kelas (nama_kelas, kode_kelas, id) FROM stdin;
10 TITL 1	X-TITL-1	1
10 TITL 2	X-TITL-2	2
10 TITL 3	X-TITL-3	3
10 TB 1	X-TB-1	4
10 TB 2	X-TB-2	5
10 AKL 1	X-AKL-1	6
10 AKL 2	X-AKL-2	7
11 TITL 1	XI-TITL-1	8
11 TITL 2	XI-TITL-2	9
11 TITL 3	XI-TITL-3	10
11 TB 1	XI-TB-1	11
11 TB 2	XI-TB-2	12
11 AKL 1	XI-AKL-1	13
11 AKL 2	XI-AKL-2	14
12 TITL 1	XII-TITL-1	15
12 TITL 2	XII-TITL-2	16
12 TB 1	XII-TB-1	17
12 TB 2	XII-TB-2	18
12 AKL 1	XII-AKL-1	19
12 AKL 2	XII-AKL-2	20
\.


--
-- Data for Name: mapels; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.mapels (id, nama_mapel) FROM stdin;
1	Pendidikan Agama Islam
2	Pendidikan Agama Kristen
3	Pendidikan Agama Budha
4	Pendidikan Agama Hindu
5	Pendidikan Agama Protestan
6	Pendidikan Pancasila
7	Bahasa Indonesia
8	Pendidikan Jasmani, Olahraga, dan Kesehatan
9	Sejarah
10	Seni Budaya
11	Matematika
12	Bahasa Inggris
13	Informatika
14	Projek Ilmu Pengetahuan Alam dan Sosial
15	Dasar-dasar Program Keahlian
16	Projek Kreatif dan Kewirausahaan
17	Mata Pelajaran Pilihan
18	Instalasi Motor Listrik
19	Instalasi Tenaga Listrik
20	Instalasi Penerangan Listrik
21	Perbaikan Peralatan Listrik
22	Desain Busana
23	Pembuatan Hiasan Busana
24	Pembuatan Busana Custom Made
25	Pembuatan Busana Industri
26	Praktikum Akuntansi Perusahaan Jasa, Dagang dan Manufaktur
27	Praktikum Akuntansi Lembaga/Instansi Pemerintah
28	Akuntansi Keuangan
29	Komputer Akuntansi
30	Administrasi Pajak
31	Bimbingan dan Konseling
32	Bahasa Jawa
33	Koding dan Kecerdasan Artifisial
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_04_20_043847_create_kelas_table	2
5	2026_04_20_043848_create_mapels_table	2
6	2026_04_20_043848_create_siswas_table	2
7	2026_04_20_043849_create_jadwals_table	2
8	2026_04_20_043849_create_presensis_table	2
9	2026_04_20_043849_create_qr_sessions_table	2
10	2026_04_20_043850_create_izins_table	2
11	2026_04_20_000001_create_users_table	3
12	2026_04_20_000002_create_kelas_table	3
13	2026_04_20_000003_create_mapels_table	3
14	2026_04_20_000004_create_jadwals_table	3
15	2026_04_20_000005_create_presensis_table	3
16	2026_04_20_065712_create_core_tables	3
17	2026_04_20_090000_add_id_to_kelas_table	4
18	2026_04_20_103907_add_tipe_to_izins_table	5
19	2026_04_20_110032_add_approved_by_to_izins_table	6
20	2026_04_21_062809_add_approved_by_to_izins_table	7
21	2026_04_22_004937_create_jurnal_mengajars_table	8
22	2026_04_22_004938_create_jurnal_presensis_table	8
23	2026_04_22_004938_create_penilaians_table	8
24	2026_04_22_013544_update_qr_sessions_table_add_guru_id_and_timestamps	9
25	2026_04_22_085630_update_presensis_table_for_detailed_tracking	9
26	2026_04_22_090500_refactor_presensis_table	9
27	2026_04_22_093754_create_catatan_siswas_table	10
28	2026_04_23_125454_create_orangtuas_table	11
29	2026_04_27_073013_add_qr_session_id_to_jurnal_mengajars_table	12
30	2026_04_27_084037_add_bukti_to_izins_table	13
31	2026_04_27_130325_add_location_to_izins_table	14
\.


--
-- Data for Name: orangtuas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.orangtuas (id, siswa_id, nama, hubungan, no_hp, username, password, created_at, updated_at) FROM stdin;
1377	84		Ayah	\N	aspasia.3869	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-27 09:13:04	2026-04-27 09:13:04
2	87	Marwiyanti	Ibu	\N	devita.3872	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:28	2026-04-27 09:13:04
4	8	Mistini	Ibu	\N	alifatun.3936	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:29	2026-04-27 09:13:04
6	10	Pilah	Ibu	\N	andrias.3938	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:30	2026-04-27 09:13:04
8	12	Darwati	Ibu	\N	aulia.3940	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:31	2026-04-27 09:13:04
10	14	Ari Susilowati	Ibu	\N	aviva.3942	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:32	2026-04-27 09:13:04
12	16	Tutik	Ibu	\N	devi.3944	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:32	2026-04-27 09:13:04
14	18	Legirah	Ibu	\N	dwi.3946	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:33	2026-04-27 09:13:04
16	20	Tri Mulyani	Ibu	\N	elza.3948	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:34	2026-04-27 09:13:04
18	22	Nurkhasanah	Ibu	\N	haniifah.3950	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:35	2026-04-27 09:13:04
20	24	Nuryani	Ibu	\N	intan.3952	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:35	2026-04-27 09:13:04
22	26	Puji Rohani	Ibu	\N	lusia.3954	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:36	2026-04-27 09:13:04
24	28	Suprihatin	Ibu	\N	nabila.3956	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:37	2026-04-27 09:13:04
28	35	Sumarni	Ibu	\N	risma.3963	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:38	2026-04-27 09:13:04
32	42	Widaryani	Ibu	\N	vika.3970	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:40	2026-04-27 09:13:04
34	43	Dian Maryanti	Ibu	\N	widya.3971	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:41	2026-04-27 09:13:04
35	48	Yatinah	Ibu	\N	andhika.3976	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:41	2026-04-27 09:13:04
39	53	Poniyati	Ibu	\N	berliana.3981	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:43	2026-04-27 09:13:04
41	56	Yanuar Handayani	Ibu	\N	dea.3984	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:43	2026-04-27 09:13:04
43	60	Urip	Ibu	\N	irna.3988	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:44	2026-04-27 09:13:04
45	63	Komaisih	Ibu	\N	meyka.3991	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:45	2026-04-27 09:13:04
47	66	Sugiyanti	Ibu	\N	novia.3994	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:46	2026-04-27 09:13:04
49	69	Warningsih	Ibu	\N	sarah.3997	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:46	2026-04-27 09:13:04
51	73	Sutinem	Ibu	\N	siti.4001	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:47	2026-04-27 09:13:04
1378	112		Ayah	\N	wiji.3897	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-27 09:13:04	2026-04-27 09:13:04
1062	417	Nur Faizah	Ibu	\N	muhammad.3536	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:05
1379	158		Ayah	\N	daffa.3764	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-27 09:13:05	2026-04-27 09:13:05
1380	188		Ayah	\N	ahmad.3794	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-27 09:13:05	2026-04-27 09:13:05
1381	257		Ayah	\N	wildan.3863	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-27 09:13:05	2026-04-27 09:13:05
717	678	Budiyati	Ibu	\N	alif.3340	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:41	2026-04-27 09:13:05
1382	234		Ayah	\N	dhimas.3840	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-27 09:13:06	2026-04-27 09:13:06
53	76	Anik	Ibu	\N	ulina.4004	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:48	2026-04-27 09:13:04
55	154	Sunting Utami	Ibu	\N	aditya.3760	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:48	2026-04-27 09:13:04
59	160	Turini	Ibu	\N	deva.3766	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:50	2026-04-27 09:13:04
61	163	Tukinem	Ibu	\N	fath.3769	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:51	2026-04-27 09:13:04
63	167	Hidayah	Ibu	\N	heksa.3773	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:52	2026-04-27 09:13:04
65	170	Daryati	Ibu	\N	marvin.3776	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:52	2026-04-27 09:13:04
67	172	Nasiati	Ibu	\N	nova.3778	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:53	2026-04-27 09:13:04
69	176	Musyarofah Indaryani	Ibu	\N	rafka.3782	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:54	2026-04-27 09:13:04
71	179	Tuminah	Ibu	\N	rizki.3785	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:54	2026-04-27 09:13:04
73	94	Tutik Ruslamdari	Ibu	\N	kristina.3879	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:55	2026-04-27 09:13:04
75	100	Aprilia Ermawati	Ibu	\N	nadira.3885	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:56	2026-04-27 09:13:04
77	103	Eka Haryati	Ibu	\N	nia.3888	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:56	2026-04-27 09:13:04
79	107	Ramini	Ibu	\N	salsa.3892	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:57	2026-04-27 09:13:04
83	115	Rika Artanti	Ibu	\N	alifa.3900	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:59	2026-04-27 09:13:04
85	125	Darwati	Ibu	\N	dini.3910	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:59	2026-04-27 09:13:04
89	135	Saryati	Ibu	\N	mita.3920	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:01	2026-04-27 09:13:04
91	138	Umi Kulsum	Ibu	\N	nafisah.3923	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:02	2026-04-27 09:13:04
93	142	Poniyem	Ibu	\N	nurul.3927	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:02	2026-04-27 09:13:04
95	145	Endriyanti	Ibu	\N	selfira.3930	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:03	2026-04-27 09:13:04
99	266	Eka Eramaya	Ibu	\N	azka.3695	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:05	2026-04-27 09:13:04
101	269	Warsinem	Ibu	\N	devina.3698	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:05	2026-04-27 09:13:04
103	186	Rinah	Ibu	\N	abi.3792	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:06	2026-04-27 09:13:04
198	414	Tri Utari	Ibu	\N	mistades.3533	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:43	2026-04-27 09:13:05
242	505	Yatiyas	Ibu	\N	deny.3454	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:00	2026-04-27 09:13:05
57	157	Wiji Lestari	Ibu	\N	azam.3763	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:49	2026-04-27 09:13:04
97	261	Murbaniyah	Ibu	\N	anaya.3690	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:04	2026-04-27 09:13:04
107	192	Sawitri	Ibu	\N	ari.3798	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:08	2026-04-27 09:13:04
109	196	Kasmi	Ibu	\N	dygta.3802	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:09	2026-04-27 09:13:04
111	199	Rojanah	Ibu	\N	fauzul.3805	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:10	2026-04-27 09:13:04
113	202	Siti Maesaroh	Ibu	\N	halimatus.3808	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:11	2026-04-27 09:13:04
115	206	Supriyati	Ibu	\N	muhammad.3812	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:11	2026-04-27 09:13:04
117	212	Supriyani	Ibu	\N	raihan.3818	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:12	2026-04-27 09:13:04
119	215	Sulinah	Ibu	\N	rivta.3821	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:13	2026-04-27 09:13:04
121	218	Fani Nurmawati	Ibu	\N	tri.3824	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:13	2026-04-27 09:13:04
123	220	Muji Rahayu	Ibu	\N	zaidan.3826	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:14	2026-04-27 09:13:04
125	223	Sutini	Ibu	\N	ahmad.3829	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:15	2026-04-27 09:13:04
127	227	Sri Widayanti	Ibu	\N	annas.3833	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:16	2026-04-27 09:13:04
129	230	Iswati	Ibu	\N	charisma.3836	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:16	2026-04-27 09:13:05
131	233	Tri Setyaningsih	Ibu	\N	destina.3839	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:17	2026-04-27 09:13:05
133	236	Wanti	Ibu	\N	fani.3842	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:18	2026-04-27 09:13:05
137	246	Tunarti	Ibu	\N	nadhif.3852	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:19	2026-04-27 09:13:05
139	249	Siti Kholifah	Ibu	\N	robbi.3855	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:20	2026-04-27 09:13:05
141	251	Rumiyati	Ibu	\N	tegar.3857	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:21	2026-04-27 09:13:05
143	254	Zait Hayati	Ibu	\N	virdo.3860	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:22	2026-04-27 09:13:05
145	353	Riyanti	Ibu	\N	riva.3622	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:23	2026-04-27 09:13:05
147	334	Rini Astuti	Ibu	\N	estu.3624	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:23	2026-04-27 09:13:05
149	339	Dwi Pujiastuti	Ibu	\N	khannaila.3629	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:24	2026-04-27 09:13:05
151	341	Rusminah	Ibu	\N	meisya.3631	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:25	2026-04-27 09:13:05
411	124	Tusri Wulandari	Ibu	\N	dinda.3909	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:59	2026-04-27 09:13:05
1239	479	Siti Rokhimah	Ibu	\N	muhamad.3598	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1287	324	Lina Lestari	Ibu	\N	vina.3753	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
157	357	Siti Asroriyah	Ibu	\N	syifa.3646	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:27	2026-04-27 09:13:05
159	360	Sumartini	Ibu	\N	yunita.3649	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:28	2026-04-27 09:13:05
161	272	Eni	Ibu	\N	fatkhur.3701	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:29	2026-04-27 09:13:05
163	275	Yuliani	Ibu	\N	helena.3704	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:30	2026-04-27 09:13:05
167	282	Nunuk Purwaningsih	Ibu	\N	pratista.3711	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:31	2026-04-27 09:13:05
169	285	Partini	Ibu	\N	rania.3714	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:32	2026-04-27 09:13:05
171	288	Kustiyani	Ibu	\N	shifa.3717	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:32	2026-04-27 09:13:05
173	292	Windarti	Ibu	\N	vina.3721	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:33	2026-04-27 09:13:05
175	295	Turiyah	Ibu	\N	deviana.3724	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:34	2026-04-27 09:13:05
177	297	Suminah	Ibu	\N	efrila.3726	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:35	2026-04-27 09:13:05
179	302	Misiyem	Ibu	\N	julia.3731	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:36	2026-04-27 09:13:05
181	305	Poniwati	Ibu	\N	linda.3734	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:37	2026-04-27 09:13:05
183	311	Ernawati	Ibu	\N	nevi.3740	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:38	2026-04-27 09:13:05
187	321	Jumini	Ibu	\N	syaila.3751	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:39	2026-04-27 09:13:05
188	323	Khomsatun	Ibu	\N	tyrza.3752	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:39	2026-04-27 09:13:05
190	399	Yulianti Farida	Ibu	\N	anang.3518	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:40	2026-04-27 09:13:05
192	403	Wahyu Dwi Astuti	Ibu	\N	epi.3522	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:41	2026-04-27 09:13:05
194	406	Mita Andriyani	Ibu	\N	farhan.3525	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:42	2026-04-27 09:13:05
196	411	Budiyanti	Ibu	\N	hafiz.3530	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:42	2026-04-27 09:13:05
200	436	Darti	Ibu	\N	arsa.3555	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:44	2026-04-27 09:13:05
202	438	Napsiyah	Ibu	\N	damar.3557	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:45	2026-04-27 09:13:05
204	440	Andriyanti	Ibu	\N	eca.3559	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:45	2026-04-27 09:13:05
266	459	Lilik Kristiyani	Ibu	\N	saiful.3578	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:08	2026-04-27 09:13:05
355	690	Suminah	Ibu	\N	firhan.3352	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:40	2026-04-27 09:13:05
817	368	Puji Riyanti	Ibu	\N	deca.3657	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:37	2026-04-27 09:13:06
983	106	Widiyati	Ibu	\N	sakina.3891	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:37	2026-04-27 09:13:06
208	445	Agustina	Ibu	\N	ikhsan.3564	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:47	2026-04-27 09:13:05
212	448	Elis Juaenah	Ibu	\N	mario.3567	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:49	2026-04-27 09:13:05
214	450	Musarofah	Ibu	\N	muhamad.3569	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:49	2026-04-27 09:13:05
216	363	Titik Suharyanti	Ibu	\N	atifa.3652	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:50	2026-04-27 09:13:05
218	367	Ropingah	Ibu	\N	aziza.3656	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:51	2026-04-27 09:13:05
220	370	Deti Triyanti	Ibu	\N	ferlita.3659	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:51	2026-04-27 09:13:05
222	372	Tumirah	Ibu	\N	fika.3661	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:52	2026-04-27 09:13:05
224	375	Dwi Wiji Astuti	Ibu	\N	lina.3664	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:53	2026-04-27 09:13:05
226	378	Surati	Ibu	\N	otrit.3668	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:54	2026-04-27 09:13:05
228	381	Rukiyah	Ibu	\N	rika.3671	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:55	2026-04-27 09:13:05
230	385	Tri Budi Rahayu	Ibu	\N	salma.3675	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:55	2026-04-27 09:13:05
232	388	Tri Atmojowati	Ibu	\N	shazia.3678	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:56	2026-04-27 09:13:05
234	391	Jumarsih	Ibu	\N	untari.3681	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:57	2026-04-27 09:13:05
236	394	Sulastri	Ibu	\N	yuda.3684	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:58	2026-04-27 09:13:05
238	498	Rubaniyah	Ibu	\N	ardiansya.3447	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:58	2026-04-27 09:13:05
240	501	Winarsih	Ibu	\N	asmaa.3450	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:59	2026-04-27 09:13:05
246	511	Siti Nurjanah	Ibu	\N	indah.3460	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:01	2026-04-27 09:13:05
248	516	Metri Yeni	Ibu	\N	lucky.3465	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:02	2026-04-27 09:13:05
250	525	Dwi Setiowati	Ibu	\N	syafrida.3474	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:03	2026-04-27 09:13:05
252	590	Supriyati	Ibu	\N	riska.3396	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:03	2026-04-27 09:13:05
254	593	Ike Dwi Astutik	Ibu	\N	safhira.3399	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:04	2026-04-27 09:13:05
428	291	Wartini	Ibu	\N	umi.3720	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:05	2026-04-27 09:13:05
472	465	Sulasiyah	Ibu	\N	akbar.3584	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:20	2026-04-27 09:13:05
488	371	Listiyatun	Ibu	\N	fibrilia.3660	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:26	2026-04-27 09:13:05
30	38	Sri Wahyuningsih	Ibu	\N	senandung.3966	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:39	2026-04-27 09:13:04
260	603	Ponimah	Ibu	\N	alisa.3409	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:06	2026-04-27 09:13:05
262	453	Siti Latifah	Ibu	\N	narindra.3572	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:07	2026-04-27 09:13:05
264	456	Romiyati	Ibu	\N	rayhan.3575	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:07	2026-04-27 09:13:05
268	463	Nur Khayatun	Ibu	\N	achmad.3582	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:09	2026-04-27 09:13:05
270	466	Mufidatun	Ibu	\N	alifia.3585	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:09	2026-04-27 09:13:05
273	471	Tumini	Ibu	\N	dhimas.3590	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:11	2026-04-27 09:13:05
275	476	Harsini	Ibu	\N	ibnu.3595	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:11	2026-04-27 09:13:05
277	477	Sri Sudiharti	Ibu	\N	iqmal.3596	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:12	2026-04-27 09:13:05
279	484	Suparti	Ibu	\N	nasichatul.3603	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:13	2026-04-27 09:13:05
281	490	Sopiyatun	Ibu	\N	sofyan.3610	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:13	2026-04-27 09:13:05
283	493	Erni Noviastuti	Ibu	\N	wildan.3613	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:14	2026-04-27 09:13:05
285	531	Budiyanti	Ibu	\N	anggia.3480	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:15	2026-04-27 09:13:05
289	538	Erniawati	Ibu	\N	bunga.3487	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:16	2026-04-27 09:13:05
291	541	Ngayem	Ibu	\N	dewi.3490	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:17	2026-04-27 09:13:05
293	544	Watiyah	Ibu	\N	eka.3493	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:18	2026-04-27 09:13:05
295	551	Parnida	Ibu	\N	jeny.3500	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:19	2026-04-27 09:13:05
299	557	Sri Masamah	Ibu	\N	norma.3506	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:20	2026-04-27 09:13:05
303	567	Suryanti	Ibu	\N	adellia.3372	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:21	2026-04-27 09:13:05
305	570	Suparminah	Ibu	\N	ata.3375	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:22	2026-04-27 09:13:05
309	578	Sumirah	Ibu	\N	fitri.3384	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:24	2026-04-27 09:13:05
311	582	Manisah	Ibu	\N	lia.3388	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:24	2026-04-27 09:13:05
313	585	Salbiyah	Ibu	\N	nadine.3391	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:25	2026-04-27 09:13:05
315	608	Sugiyem	Ibu	\N	ariya.3414	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:26	2026-04-27 09:13:05
317	612	Aan Yuliani	Ibu	\N	cahya.3418	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:27	2026-04-27 09:13:05
319	615	Turinah	Ibu	\N	dewik.3421	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:27	2026-04-27 09:13:05
321	624	Indrayati	Ibu	\N	melya.3430	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:28	2026-04-27 09:13:05
323	626	Kasinah	Ibu	\N	miki.3432	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:29	2026-04-27 09:13:05
325	631	Tutik	Ibu	\N	safa.3437	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:29	2026-04-27 09:13:05
329	639	Siti Rifani	Ibu	\N	andra.3301	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:31	2026-04-27 09:13:05
331	642	Sri Sumarsih	Ibu	\N	bayu.3304	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:31	2026-04-27 09:13:05
333	649	Sopiyah	Ibu	\N	ello.3311	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:32	2026-04-27 09:13:05
335	652	Rupinah	Ibu	\N	faisal.3314	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:33	2026-04-27 09:13:05
337	659	Suyati	Ibu	\N	novita.3321	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:34	2026-04-27 09:13:05
339	662	Riadiningsih	Ibu	\N	raditya.3324	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:34	2026-04-27 09:13:05
341	665	Winarsih	Ibu	\N	restu.3327	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:35	2026-04-27 09:13:05
345	672	Mulyanah	Ibu	\N	wahyu.3334	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:36	2026-04-27 09:13:05
347	674	Siti Rosidah	Ibu	\N	abey.3336	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:37	2026-04-27 09:13:05
349	680	Siti Uswatun Kasanah	Ibu	\N	andika.3342	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:38	2026-04-27 09:13:05
351	683	Duwi Ariyani	Ibu	\N	asty.3345	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:38	2026-04-27 09:13:05
353	687	Sri Muryani	Ibu	\N	dimas.3349	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:39	2026-04-27 09:13:05
357	80	Ngatijem	Ibu	\N	alya.3865	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:40	2026-04-27 09:13:05
500	502	Rusyanti	Ibu	\N	attaya.3451	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:30	2026-04-27 09:13:05
512	537	Suyanti	Ibu	\N	azzahra.3486	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:38	2026-04-27 09:13:05
715	675	Mursini	Ibu	\N	agus.3337	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:39	2026-04-27 09:13:05
81	110	Sarminah	Ibu	\N	tiara.3895	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:58	2026-04-27 09:13:04
359	31	Ernawati	Ibu	\N	neva.3959	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:41	2026-04-27 09:13:05
361	36	Wagiyati	Ibu	\N	rizka.3964	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:42	2026-04-27 09:13:05
363	41	Komsiyah	Ibu	\N	talitha.3969	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:42	2026-04-27 09:13:05
365	46	Anik Estiana	Ibu	\N	almira.3974	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:43	2026-04-27 09:13:05
367	57	Desy Prasetyaningrum	Ibu	\N	dewinta.3985	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:44	2026-04-27 09:13:05
369	62	Sekti Afriani	Ibu	\N	livera.3990	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:44	2026-04-27 09:13:05
371	67	Tri Haryani	Ibu	\N	rafa.3995	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:45	2026-04-27 09:13:05
373	72	Murni	Ibu	\N	sholeh.4000	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:46	2026-04-27 09:13:05
375	77	Diyah Windiarti	Ibu	\N	zelita.4005	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:46	2026-04-27 09:13:05
377	698	Ngatirah	Ibu	\N	rangga.3360	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:47	2026-04-27 09:13:05
379	701	Julaeha	Ibu	\N	sakha.3363	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:48	2026-04-27 09:13:05
381	704	Ngadinah	Ibu	\N	solehudin.3366	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:49	2026-04-27 09:13:05
385	161	Sariyah	Ibu	\N	didi.3767	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:50	2026-04-27 09:13:05
387	166	Retno Wigati	Ibu	\N	gian.3772	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:51	2026-04-27 09:13:05
389	171	Jumiati	Ibu	\N	muchamad.3777	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:51	2026-04-27 09:13:05
391	175	Sutini	Ibu	\N	rafiq.3781	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:52	2026-04-27 09:13:05
395	185	Rochaniyah	Ibu	\N	zidni.3791	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:53	2026-04-27 09:13:05
397	193	Yuli Utami	Ibu	\N	aufaa.3799	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:54	2026-04-27 09:13:05
399	83	Nur Paryanti	Ibu	\N	asa.3868	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:55	2026-04-27 09:13:05
401	91	Supiah	Ibu	\N	enike.3876	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:55	2026-04-27 09:13:05
403	93	Tatik Asnawati	Ibu	\N	jevanie.3878	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:56	2026-04-27 09:13:05
407	114	Siti Fatimah	Ibu	\N	zita.3899	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:57	2026-04-27 09:13:05
695	634	Tri Marsini	Ibu	\N	suci.3440	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:21	2026-04-27 09:13:05
413	134	Saodah	Ibu	\N	mila.3919	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:59	2026-04-27 09:13:05
414	139	Wahyudi	Ayah	\N	nida.3924	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:00	2026-04-27 09:13:05
416	143	Ngayem	Ibu	\N	putik.3928	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:01	2026-04-27 09:13:05
422	273	Warsih	Ibu	\N	fuji.3702	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:03	2026-04-27 09:13:05
424	276	Suranti	Ibu	\N	isabitha.3705	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:03	2026-04-27 09:13:05
426	286	Nur Hasanah	Ibu	\N	retno.3715	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:04	2026-04-27 09:13:05
430	301	Rosidah	Ibu	\N	jesica.3730	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:06	2026-04-27 09:13:05
432	306	Supriyani	Ibu	\N	lita.3735	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:06	2026-04-27 09:13:05
434	312	Supriani	Ibu	\N	nur.3741	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:07	2026-04-27 09:13:05
436	317	Dwi Budi Lestari	Ibu	\N	ratri.3746	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:08	2026-04-27 09:13:05
438	325	Suwanti	Ibu	\N	wening.3754	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:08	2026-04-27 09:13:05
440	198	Zubaidah	Ibu	\N	fathurrahman.3804	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:09	2026-04-27 09:13:05
442	203	Maemonah	Ibu	\N	ilham.3809	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:10	2026-04-27 09:13:05
444	221	Solihah Aisah	Ibu	\N	zalfa.3827	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:11	2026-04-27 09:13:05
446	229	Wagiarti	Ibu	\N	arini.3835	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:12	2026-04-27 09:13:05
448	232	Helmawati	Ibu	\N	dawam.3838	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:12	2026-04-27 09:13:05
450	247	Maryatun	Ibu	\N	nafis.3853	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:13	2026-04-27 09:13:05
452	252	Pariyah	Ibu	\N	tria.3858	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:14	2026-04-27 09:13:05
454	402	Ratmiyati	Ibu	\N	deby.3521	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:14	2026-04-27 09:13:05
456	407	Yulimah	Ibu	\N	farid.3526	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:15	2026-04-27 09:13:05
458	410	Etik Rubiyanti	Ibu	\N	habib.3529	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:15	2026-04-27 09:13:05
973	92	Sutari	Ibu	\N	ernawati.3877	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:34	2026-04-27 09:13:06
87	132	Endah Larasati	Ibu	\N	meita.3917	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:00	2026-04-27 09:13:04
464	444	Dwi Endah Yuliawati	Ibu	\N	ibram.3563	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:17	2026-04-27 09:13:05
466	447	Safitri	Ibu	\N	jibran.3566	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:18	2026-04-27 09:13:05
468	449	Asmuriah	Ibu	\N	mohamad.3568	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:19	2026-04-27 09:13:05
470	460	Tentrem Ekowati	Ibu	\N	syarif.3579	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:19	2026-04-27 09:13:05
474	470	Supriyati	Ibu	\N	cahyo.3589	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:21	2026-04-27 09:13:05
476	337	Sutriyani	Ibu	\N	gita.3627	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:22	2026-04-27 09:13:05
478	343	Tri Supriyanti	Ibu	\N	melinda.3633	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:22	2026-04-27 09:13:05
480	346	Mistun	Ibu	\N	noviana.3636	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:23	2026-04-27 09:13:05
482	351	Kholimah	Ibu	\N	ricka.3641	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:24	2026-04-27 09:13:05
484	361	Suheriyah	Ibu	\N	zulfa.3650	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:25	2026-04-27 09:13:05
486	366	Karlinawati	Ibu	\N	ayu.3655	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:25	2026-04-27 09:13:05
490	377	Venti Fatimah	Ibu	\N	novi.3667	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:27	2026-04-27 09:13:05
492	382	Harwani	Ibu	\N	risa.3672	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:27	2026-04-27 09:13:05
496	389	Misyanti	Ibu	\N	silfara.3679	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:29	2026-04-27 09:13:05
498	395	Sri Lestari	Ibu	\N	zahwa.3685	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:29	2026-04-27 09:13:05
502	512	Suparnik	Ibu	\N	indri.3461	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:31	2026-04-27 09:13:05
504	515	Baroyah	Ibu	\N	lana.3464	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:32	2026-04-27 09:13:05
506	518	Amalin Atiqoh	Ibu	\N	malika.3467	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:33	2026-04-27 09:13:05
508	521	Yustini	Ibu	\N	navila.3470	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:35	2026-04-27 09:13:05
510	532	Parini	Ibu	\N	arinda.3481	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:37	2026-04-27 09:13:05
747	412	Kisrowiyah	Ibu	\N	keisa.3531	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:04	2026-04-27 09:13:06
821	374	Kartini	Ibu	\N	khoniatun.3663	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:39	2026-04-27 09:13:06
516	553	Imas Noeraini	Ibu	\N	kalisa.3502	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:42	2026-04-27 09:13:05
518	558	Lilawati	Ibu	\N	okta.3507	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:44	2026-04-27 09:13:05
520	563	Supriasih	Ibu	\N	sheril.3512	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:44	2026-04-27 09:13:05
522	568	Umi Habibah	Ibu	\N	aprilia.3373	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:45	2026-04-27 09:13:05
524	573	Chotimah	Ibu	\N	desy.3378	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:46	2026-04-27 09:13:05
526	579	Fitri Dwi Hartati	Ibu	\N	fiyona.3385	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:46	2026-04-27 09:13:05
528	584	Rasinem	Ibu	\N	nabilla.3390	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:47	2026-04-27 09:13:05
530	602	Sunarti	Ibu	\N	alfbia.3408	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:48	2026-04-27 09:13:05
532	605	Yatiyas	Ibu	\N	anik.3411	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:49	2026-04-27 09:13:05
534	609	Umi Siswati	Ibu	\N	auliya.3415	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:50	2026-04-27 09:13:05
536	614	Isma'Rifah	Ibu	\N	della.3420	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:50	2026-04-27 09:13:05
538	473	Supriyana	Ibu	\N	eliya.3592	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:51	2026-04-27 09:13:05
540	483	Yuliani	Ibu	\N	najwa.3602	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:52	2026-04-27 09:13:05
542	489	Sunarsih	Ibu	\N	slamet.3609	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:52	2026-04-27 09:13:05
544	494	Sri Lestari	Ibu	\N	yanuar.3614	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:53	2026-04-27 09:13:05
546	620	Muntaiyah	Ibu	\N	kurnia.3426	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:54	2026-04-27 09:13:05
548	622	Wantiyem	Ibu	\N	lisvia.3428	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:55	2026-04-27 09:13:05
550	625	Lasmi	Ibu	\N	merlina.3431	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:55	2026-04-27 09:13:05
552	628	Ina Dwiningsih	Ibu	\N	nila.3434	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:56	2026-04-27 09:13:05
554	630	Narti	Ibu	\N	ririn.3436	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:57	2026-04-27 09:13:05
556	635	Maryani	Ibu	\N	vera.3441	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:57	2026-04-27 09:13:05
558	638	Asih	Ibu	\N	amin.3300	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:58	2026-04-27 09:13:05
560	640	Yuniarti	Ibu	\N	arif.3302	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:59	2026-04-27 09:13:05
1173	592	Rukmini	Ibu	\N	rizka.3398	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
258	599	Wijayanti	Ibu	\N	tiyas.3405	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:05	2026-04-27 09:13:05
462	441	Anik Rahmawati	Ibu	\N	farkhan.3560	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:17	2026-04-27 09:13:05
568	650	Saridah	Ibu	\N	eryawan.3312	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:01	2026-04-27 09:13:05
570	653	Jumiati	Ibu	\N	giega.3315	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:02	2026-04-27 09:13:05
572	655	Susanti	Ibu	\N	kezan.3317	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:03	2026-04-27 09:13:05
574	661	Tri Suntari	Ibu	\N	prima.3323	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:03	2026-04-27 09:13:05
576	666	Ngatini	Ibu	\N	ridho.3328	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:04	2026-04-27 09:13:05
578	668	Suranti	Ibu	\N	sahrul.3330	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:05	2026-04-27 09:13:05
580	671	Sudarmisih	Ibu	\N	vanan.3333	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:06	2026-04-27 09:13:05
584	691	Istiyani	Ibu	\N	gunawan.3353	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:07	2026-04-27 09:13:05
586	693	Parlina	Ibu	\N	irfan.3355	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:08	2026-04-27 09:13:05
588	697	Fepri Apsari	Ibu	\N	raffi.3359	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:08	2026-04-27 09:13:05
590	702	Henny Kuswandari	Ibu	\N	salsabilla.3364	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:09	2026-04-27 09:13:05
592	495	Lis Handayani	Ibu	\N	abidzar.3444	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:10	2026-04-27 09:13:05
594	496	Wartiningsih	Ibu	\N	adelia.3445	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:11	2026-04-27 09:13:05
596	497	Kuswaningsih	Ibu	\N	afiifah.3446	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:11	2026-04-27 09:13:05
598	499	Noviana Ariani	Ibu	\N	arina.3448	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:12	2026-04-27 09:13:05
600	503	Eny Supriyati	Ibu	\N	cindy.3452	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:13	2026-04-27 09:13:05
602	506	Resmi Setyawati	Ibu	\N	dila.3455	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:14	2026-04-27 09:13:05
604	509	Supriyani	Ibu	\N	ferlyta.3458	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:14	2026-04-27 09:13:05
606	510	Tuti Hidayati	Ibu	\N	fiani.3459	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:15	2026-04-27 09:13:05
608	514	Warsiyah	Ibu	\N	isna.3463	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:16	2026-04-27 09:13:05
610	517	Parningsih	Ibu	\N	lufki.3466	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:18	2026-04-27 09:13:05
923	181	Ajeng Meilina Prastiwaningtyas	Ibu	\N	satrio.3787	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:15	2026-04-27 09:13:06
514	547	Ismiati Herlina	Ibu	\N	fellysha.3496	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:40	2026-04-27 09:13:05
614	520	Pardiyah	Ibu	\N	muharromah.3469	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:21	2026-04-27 09:13:05
618	524	Suyanti	Ibu	\N	syafiatun.3473	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:24	2026-04-27 09:13:05
620	528	Sumirah	Ibu	\N	winda.3477	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:26	2026-04-27 09:13:05
621	529	Ramiyati	Ibu	\N	yuliana.3478	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:27	2026-04-27 09:13:05
623	530	Suci	Ibu	\N	yulianita.3479	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:29	2026-04-27 09:13:05
625	533	Nanung Marlina	Ibu	\N	arla.3482	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:30	2026-04-27 09:13:05
627	536	Diyah Kariyani	Ibu	\N	azizah.3485	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:32	2026-04-27 09:13:05
629	539	Suryani	Ibu	\N	dania.3488	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:34	2026-04-27 09:13:05
631	540	Enggar Handiani	Ibu	\N	dendy.3489	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:35	2026-04-27 09:13:05
633	546	Apriyani	Ibu	\N	eni.3495	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:37	2026-04-27 09:13:05
635	549	Nur Komariyah	Ibu	\N	hasna.3498	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:39	2026-04-27 09:13:05
641	555	Suratmi	Ibu	\N	livia.3504	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:42	2026-04-27 09:13:05
645	559	Nunuk Sri Rahayu	Ibu	\N	rama.3508	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:44	2026-04-27 09:13:05
647	560	Tukinah	Ibu	\N	reynata.3509	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:45	2026-04-27 09:13:05
649	562	Sudarwati	Ibu	\N	seza.3511	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:46	2026-04-27 09:13:05
651	565	Lilis Kurniati	Ibu	\N	vicco.3514	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:46	2026-04-27 09:13:05
653	566	Urip Febriwati	Ibu	\N	zaskia.3515	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:47	2026-04-27 09:13:05
655	569	Catur Murni	Ibu	\N	aqil.3374	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:48	2026-04-27 09:13:05
659	572	Yeni Mariyanti	Ibu	\N	cahaya.3377	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:49	2026-04-27 09:13:05
661	576	Sopiyah	Ibu	\N	echa.3381	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:51	2026-04-27 09:13:05
663	577	Poniyem	Ibu	\N	edy.3382	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:52	2026-04-27 09:13:05
667	583	Sri Mulyani	Ibu	\N	lutfika.3389	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:56	2026-04-27 09:13:05
669	589	Kadarningsih	Ibu	\N	ratih.3395	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:58	2026-04-27 09:13:05
671	594	Umi Haryanti	Ibu	\N	selly.3400	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:59	2026-04-27 09:13:05
675	598	Ratini	Ibu	\N	tintia.3404	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:03	2026-04-27 09:13:05
677	601	Musri	Ibu	\N	widhi.3407	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:05	2026-04-27 09:13:05
679	604	Tati Nurhayati	Ibu	\N	amelia.3410	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:07	2026-04-27 09:13:05
681	606	Barijah	Ibu	\N	arifah.3412	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:09	2026-04-27 09:13:05
683	607	Anis Sulatifah	Ibu	\N	arista.3413	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:10	2026-04-27 09:13:05
685	616	Tibah Lestari	Ibu	\N	divanda.3422	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:12	2026-04-27 09:13:05
687	617	Siti Kotimah	Ibu	\N	fadhilah.3423	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:14	2026-04-27 09:13:05
689	619	Turiyem	Ibu	\N	kholifatul.3425	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:15	2026-04-27 09:13:05
693	629	Wardaningsih	Ibu	\N	queen.3435	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:19	2026-04-27 09:13:05
697	636	Tuminah Isnaini	Ibu	\N	vrisca.3442	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:23	2026-04-27 09:13:05
699	641	Dwi Susiani	Ibu	\N	arlita.3303	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:25	2026-04-27 09:13:05
701	644	Suklimah	Ibu	\N	damarjati.3306	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:26	2026-04-27 09:13:05
703	651	Sunarti	Ibu	\N	fahri.3313	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:28	2026-04-27 09:13:05
705	654	Winnarti	Ibu	\N	jatmiko.3316	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:30	2026-04-27 09:13:05
707	660	Rita Prihatini	Ibu	\N	pandu.3322	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:32	2026-04-27 09:13:05
709	664	Warliah	Ibu	\N	reni.3326	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:34	2026-04-27 09:13:05
711	670	Wagiyah	Ibu	\N	syahzid.3332	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:35	2026-04-27 09:13:05
713	673	Nuning Riyanti	Ibu	\N	wisnu.3335	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:37	2026-04-27 09:13:05
785	486	Puji Hariyanti	Ibu	\N	revinja.3606	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:26	2026-04-27 09:13:06
965	82	Siti Rochanah	Ibu	\N	anis.3867	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:31	2026-04-27 09:13:06
26	32	Dwi Fitri Lestari	Ibu	\N	octa.3960	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:38	2026-04-27 09:13:04
719	679	Sukarjilah	Ibu	\N	andicka.3341	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:42	2026-04-27 09:13:05
721	682	Ngamilah	Ibu	\N	ashfi.3344	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:44	2026-04-27 09:13:06
723	685	Saimah	Ibu	\N	dafa.3347	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:46	2026-04-27 09:13:06
725	688	Muntinah	Ibu	\N	fahrizal.3350	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:48	2026-04-27 09:13:06
727	689	Fitriyati	Ibu	\N	fery.3351	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:49	2026-04-27 09:13:06
729	703	Mukholidatun	Ibu	\N	satria.3365	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:51	2026-04-27 09:13:06
731	705	Fatoyah	Ibu	\N	sukur.3367	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:53	2026-04-27 09:13:06
735	708	Ngatini	Ibu	\N	yoghi.3370	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:57	2026-04-27 09:13:06
737	397	Wahyuni Tri Purwanti	Ibu	\N	abigail.3516	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:58	2026-04-27 09:13:06
739	400	Puji Astuti	Ibu	\N	daffa.3519	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:00	2026-04-27 09:13:06
743	404	Maesaroh	Ibu	\N	eva.3523	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:02	2026-04-27 09:13:06
745	405	Sri Wahyuni	Ibu	\N	fajar.3524	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:03	2026-04-27 09:13:06
749	413	Euis Maemunah	Ibu	\N	keyla.3532	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:05	2026-04-27 09:13:06
751	418	Fatimah	Ibu	\N	nafalsa.3537	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:05	2026-04-27 09:13:06
753	422	Dede Triyana	Ibu	\N	susanto.3541	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:06	2026-04-27 09:13:06
755	423	Ida Suramaryati	Ibu	\N	tasyahara.3542	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:07	2026-04-27 09:13:06
757	425	Indah Wijayanti	Ibu	\N	wisetya.3544	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:08	2026-04-27 09:13:06
759	427	Suyanti	Ibu	\N	zhafran.3546	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:09	2026-04-27 09:13:06
761	428	Retno Arumsasi	Ibu	\N	zidan.3547	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:11	2026-04-27 09:13:06
763	429	Sugiarti	Ibu	\N	zuhrul.3548	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:13	2026-04-27 09:13:06
765	433	Kamsidah	Ibu	\N	alhafit.3552	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:14	2026-04-27 09:13:06
837	259	Era Ratih Ayu Puspita Sari	Ibu	\N	alexandria.3688	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:44	2026-04-27 09:13:06
105	189	Suheri	Ibu	\N	aiful.3795	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:07	2026-04-27 09:13:04
769	435	Sumilah	Ibu	\N	ardiansyah.3554	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:18	2026-04-27 09:13:06
771	457	Surati	Ibu	\N	rian.3576	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:20	2026-04-27 09:13:06
773	461	Ponijem	Ibu	\N	triyono.3580	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:21	2026-04-27 09:13:06
775	467	Darmini	Ibu	\N	ananda.3586	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:22	2026-04-27 09:13:06
777	468	Kustiati	Ibu	\N	andian.3587	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:23	2026-04-27 09:13:06
781	475	Suliyati	Ibu	\N	hendry.3594	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:24	2026-04-27 09:13:06
783	485	Rina Rosdiyana	Ibu	\N	natasya.3604	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:25	2026-04-27 09:13:06
787	488	Sudaryani	Ibu	\N	setya.3608	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:27	2026-04-27 09:13:06
789	491	Mugi  Setyaningsih	Ibu	\N	suhgi.3611	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:27	2026-04-27 09:13:06
791	329	Kharima	Ibu	\N	arleta.3617	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:28	2026-04-27 09:13:06
793	333	Sutari	Ibu	\N	erniyanti.3623	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:29	2026-04-27 09:13:06
795	335	Mutmainah	Ibu	\N	febria.3625	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:29	2026-04-27 09:13:06
797	338	Hepna Palupi	Ibu	\N	keira.3628	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:30	2026-04-27 09:13:06
799	340	Tusini	Ibu	\N	lutfiatul.3630	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:31	2026-04-27 09:13:06
801	342	Jumilah	Ibu	\N	melani.3632	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:31	2026-04-27 09:13:06
803	344	Tugini	Ibu	\N	nana.3634	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:32	2026-04-27 09:13:06
805	348	Kasmilah	Ibu	\N	oktaviana.3638	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:33	2026-04-27 09:13:06
807	354	Emayanti	Ibu	\N	septia.3643	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:33	2026-04-27 09:13:06
809	355	Sutiarni	Ibu	\N	silvi.3644	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:34	2026-04-27 09:13:06
811	358	Sukini	Ibu	\N	veronika.3647	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:35	2026-04-27 09:13:06
813	362	Peni Haryani	Ibu	\N	alfira.3651	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:36	2026-04-27 09:13:06
815	365	Waluyo Rokhidin	Ibu	\N	awalina.3654	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:37	2026-04-27 09:13:06
1064	443	Endang Widiastuti	Ibu	\N	galang.3562	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
420	262	Tri Sulistiyanti	Ibu	\N	angger.3691	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:02	2026-04-27 09:13:05
819	373	Supriyami	Ibu	\N	heny.3662	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:38	2026-04-27 09:13:06
823	379	Legisem	Ibu	\N	priati.3669	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:39	2026-04-27 09:13:06
827	386	Purmaningsih	Ibu	\N	sarinadatun.3676	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:41	2026-04-27 09:13:06
829	387	Muslimah	Ibu	\N	selvia.3677	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:41	2026-04-27 09:13:06
831	392	Sri Purwanti	Ibu	\N	vebryana.3682	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:42	2026-04-27 09:13:06
833	393	Haryani	Ibu	\N	wiedho.3683	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:43	2026-04-27 09:13:06
835	396	Ni Wayan Sumanis	Ibu	\N	zulia.3686	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:44	2026-04-27 09:13:06
839	260	Sukesi	Ibu	\N	ambar.3689	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:45	2026-04-27 09:13:06
841	267	Heba Sulistiani	Ibu	\N	deaundre.3696	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:46	2026-04-27 09:13:06
843	271	Sukiswati	Ibu	\N	fadila.3700	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:46	2026-04-27 09:13:06
845	274	Djamilah	Ibu	\N	hari.3703	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:47	2026-04-27 09:13:06
847	277	Isrofijah	Ibu	\N	isnaini.3706	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:48	2026-04-27 09:13:06
849	278	Sriyanti	Ibu	\N	laila.3707	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:48	2026-04-27 09:13:06
851	280	Sri Suranti	Ibu	\N	miftahul.3709	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:49	2026-04-27 09:13:06
853	283	Aruming Puji Wahyuni	Ibu	\N	rahma.3712	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:50	2026-04-27 09:13:06
855	284	Sueni	Ibu	\N	ramdhan.3713	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:51	2026-04-27 09:13:06
857	287	Siti Mulyana	Ibu	\N	saras.3716	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:51	2026-04-27 09:13:06
859	289	Senemi	Ibu	\N	sifa.3718	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:52	2026-04-27 09:13:06
861	293	Siti Agustina	Ibu	\N	alfina.3722	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:53	2026-04-27 09:13:06
863	294	Listiyanti Winarsih	Ibu	\N	cera.3723	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:54	2026-04-27 09:13:06
865	299	Sopiyah	Ibu	\N	fiandra.3728	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:54	2026-04-27 09:13:06
867	304	Yuli Astuti	Ibu	\N	lare.3733	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:55	2026-04-27 09:13:06
665	580	Suharti	Ibu	\N	gunarti.3386	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:54	2026-04-27 09:13:05
691	627	Yatinem	Ibu	\N	muthia.3433	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:17	2026-04-27 09:13:05
871	310	Ari Irawati	Ibu	\N	nailina.3739	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:57	2026-04-27 09:13:06
873	313	Tri Andri Alung	Ibu	\N	peny.3742	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:57	2026-04-27 09:13:06
875	314	Sumartini	Ibu	\N	poundra.3743	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:58	2026-04-27 09:13:06
877	316	Saminah	Ibu	\N	rahayu.3745	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:59	2026-04-27 09:13:06
879	320	Satinah	Ibu	\N	silvia.3750	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:59	2026-04-27 09:13:06
881	326	Paijem	Ibu	\N	wiji.3755	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:00	2026-04-27 09:13:06
883	327	Timah	Ibu	\N	yeni.3756	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:01	2026-04-27 09:13:06
887	156	Pujiani	Ibu	\N	asmar.3762	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:02	2026-04-27 09:13:06
889	19	Ponisah	Ibu	\N	een.3947	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:03	2026-04-27 09:13:06
891	21	Emallia Mahardika	Ibu	\N	fayola.3949	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:04	2026-04-27 09:13:06
893	23	Supanti	Ibu	\N	inesta.3951	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:05	2026-04-27 09:13:06
895	25	Tusmiati	Ibu	\N	latifah.3953	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:05	2026-04-27 09:13:06
901	30	Suparmi Anggoro Dewi	Ibu	\N	naylla.3958	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:08	2026-04-27 09:13:06
903	33	Wiwin Islindawati	Ibu	\N	rahayuningtyas.3961	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:08	2026-04-27 09:13:06
905	34	Sugi Herawati	Ibu	\N	reivan.3962	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:09	2026-04-27 09:13:06
907	37	Siti Rodiah	Ibu	\N	sazkiya.3965	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:10	2026-04-27 09:13:06
909	159	Sunaryati	Ibu	\N	davin.3765	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:10	2026-04-27 09:13:06
911	162	Setyaningsih	Ibu	\N	fakhri.3768	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:11	2026-04-27 09:13:06
913	165	Ambar Sari	Ibu	\N	ganjar.3771	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:12	2026-04-27 09:13:06
915	168	Nuryanti	Ibu	\N	hema.3774	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:12	2026-04-27 09:13:06
917	169	Sukarti	Ibu	\N	jihan.3775	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:13	2026-04-27 09:13:06
1334	256	Isnur Chotimah	Ibu	\N	wahyu.3862	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
995	133	Sukitri	Ibu	\N	meylani.3918	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:42	2026-04-27 09:13:06
210	446	Novalia Andini Saputri	Ibu	\N	inggo.3565	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:48	2026-04-27 09:13:05
1074	487	Ernawati	Ibu	\N	rizki.3607	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
885	155	Suprapti	Ibu	\N	akhyar.3761	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:02	2026-04-27 09:13:06
921	174	Yulinar	Ibu	\N	radisa.3780	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:15	2026-04-27 09:13:06
925	183	Sawitri	Ibu	\N	trida.3789	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:16	2026-04-27 09:13:06
927	184	Mudrikah	Ibu	\N	ulfa.3790	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:17	2026-04-27 09:13:06
929	187	Puji Astuti	Ibu	\N	adrian.3793	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:18	2026-04-27 09:13:06
931	191	Sukini	Ibu	\N	allin.3797	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:18	2026-04-27 09:13:06
933	194	Hidayah	Ibu	\N	celvin.3800	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:19	2026-04-27 09:13:06
935	197	Ngatiyem	Ibu	\N	edi.3803	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:20	2026-04-27 09:13:06
937	200	Rochimah	Ibu	\N	firdan.3806	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:20	2026-04-27 09:13:06
939	219	Herna Wati Rahayu	Ibu	\N	vitra.3825	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:21	2026-04-27 09:13:06
941	222	Lestari	Ibu	\N	afiq.3828	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:22	2026-04-27 09:13:06
943	225	Ariyanti	Ibu	\N	aldo.3831	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:22	2026-04-27 09:13:06
945	226	Sutrisni	Ibu	\N	alvino.3832	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:23	2026-04-27 09:13:06
947	228	Umi Nurhidayah	Ibu	\N	ardian.3834	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:24	2026-04-27 09:13:06
949	237	Umi Dian Lestari	Ibu	\N	ghufron.3843	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:25	2026-04-27 09:13:06
951	238	Sunarti	Ibu	\N	ifank.3844	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:26	2026-04-27 09:13:06
953	245	Prihatin	Ibu	\N	mustaqiim.3851	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:26	2026-04-27 09:13:06
955	248	Supriatin	Ibu	\N	rakha.3854	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:27	2026-04-27 09:13:06
957	250	Jumiyati	Ibu	\N	sardiyono.3856	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:28	2026-04-27 09:13:06
959	253	Rita Marlita	Ibu	\N	tya.3859	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:29	2026-04-27 09:13:06
961	79	Puji Lestari	Ibu	\N	aida.3864	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:29	2026-04-27 09:13:06
963	81	Sugianti	Ibu	\N	anggita.3866	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:30	2026-04-27 09:13:06
967	85	Tri Yanuari	Ibu	\N	cinta.3870	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:32	2026-04-27 09:13:06
969	86	Umi Salamah	Ibu	\N	danisha.3871	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:32	2026-04-27 09:13:06
673	595	Pintaryati	Ibu	\N	shafa.3401	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:01	2026-04-27 09:13:05
975	95	Riyanti	Ibu	\N	marta.3880	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:35	2026-04-27 09:13:06
977	99	Nur Dewi Zulaekhah	Ibu	\N	nadia.3884	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:35	2026-04-27 09:13:06
979	101	Sudaryanti	Ibu	\N	nailah.3886	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:36	2026-04-27 09:13:06
981	102	Erna Wahyu Lestari	Ibu	\N	nayla.3887	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:37	2026-04-27 09:13:06
985	108	Astutik	Ibu	\N	shavina.3893	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:38	2026-04-27 09:13:06
987	126	Satilah	Ibu	\N	diva.3911	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:39	2026-04-27 09:13:06
989	127	Budiyanti	Ibu	\N	duta.3912	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:40	2026-04-27 09:13:06
991	130	Tusiyam	Ibu	\N	eri.3915	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:40	2026-04-27 09:13:06
993	131	Suliyah	Ibu	\N	ika.3916	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:41	2026-04-27 09:13:06
997	136	Sulestari	Ibu	\N	mufidatus.3921	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:42	2026-04-27 09:13:06
999	140	Suparti	Ibu	\N	nisa.3925	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:43	2026-04-27 09:13:06
1001	144	Nunung Trihisti	Ibu	\N	sava.3929	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:44	2026-04-27 09:13:06
1003	146	Legiwati	Ibu	\N	shofiya.3931	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:44	2026-04-27 09:13:06
1004	147	Anni Rachmawati	Ibu	\N	sofi.3932	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:45	2026-04-27 09:13:06
1005	11	Siti Dewi Ningsih	Ibu	\N	anisya.3939	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:45	2026-04-27 09:13:06
1007	13	Ronjiyah	Ibu	\N	aulya.3941	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:46	2026-04-27 09:13:06
1009	15	Wahyu Melati Pertiwi	Ibu	\N	darin.3943	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:47	2026-04-27 09:13:06
1011	44	Wahyu Suciati	Ibu	\N	aleta.3972	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:48	2026-04-27 09:13:06
1013	45	Winarti	Ibu	\N	alfi.3973	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:48	2026-04-27 09:13:06
1015	47	Tutik Widayati	Ibu	\N	ammar.3975	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:49	2026-04-27 09:13:06
1017	49	Agus Suratini	Ibu	\N	anita.3977	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:50	2026-04-27 09:13:06
1019	54	Puriyantiningsih	Ibu	\N	choirunnisa.3982	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:50	2026-04-27 09:13:06
1034	90	Parmi	Ibu	\N	dwi.3875	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:04
1036	97	Sri Lestari	Ibu	\N	nabila.3882	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:04
1038	118	Mariyah	Ibu	\N	annisa.3903	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:04
1042	128	Sugiyanti	Ibu	\N	dwi.3913	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:04
1044	149	Maniek Vina Ismawati	Ibu	\N	tiara.3934	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:04
1046	263	Suprih Susanti	Ibu	\N	annisa.3692	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:04
1048	182	Siti Jamilah	Ibu	\N	siti.3788	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:04
1050	209	Satriyati	Ibu	\N	muhammad.3815	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:04
1052	243	Winarti	Ibu	\N	muhammad.3849	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:05
1054	330	Riyana	Ibu	\N	aulia.3618	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:05
1056	345	Venti Fatimah	Ibu	\N	nova.3635	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:05
155	352	Wagiyem	Ibu	\N	rita.3642	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:27	2026-04-27 09:13:05
1058	309	Sutrismi	Ibu	\N	nabila.3738	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:05
1060	315	Kasanah	Ibu	\N	putri.3744	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:05
185	318	Ririn Wahyuni	Ibu	\N	rifka.3747	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:38	2026-04-27 09:13:05
405	104	Wasiyah	Ibu	\N	olivia.3889	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:57	2026-04-27 09:13:05
897	27	Ichti Nuriyah	Ibu	\N	mutiara.3955	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:06	2026-04-27 09:13:06
1024	61	Yuli Ernawati	Ibu	\N	lea.3989	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:52	2026-04-27 09:13:06
1026	68	Sutinah	Ibu	\N	rima.3996	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:53	2026-04-27 09:13:06
1028	71	Ngatini	Ibu	\N	septi.3999	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:54	2026-04-27 09:13:06
1030	75	Sariyem	Ibu	\N	trianda.4003	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:54	2026-04-27 09:13:06
1032	78	Sari Hatiningsih	Ibu	\N	zullia.4006	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:55	2026-04-27 09:13:06
1066	451	Supratmi	Ibu	\N	muhammad.3570	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1068	513	Siti Rifani	Ibu	\N	intan.3462	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1070	522	Nuri Lestari	Ibu	\N	nova.3471	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
256	596	Wagini	Ibu	\N	sheila.3402	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:05	2026-04-27 09:13:05
271	469	Prihatin Puji Rahayu	Ibu	\N	arya.3588	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:10	2026-04-27 09:13:05
1072	481	Chairusiyam	Ibu	\N	muhammad.3600	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1076	548	Parijah	Ibu	\N	fika.3497	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1078	564	Siti Munawaroh	Ibu	\N	siti.3513	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1080	574	Sarmi	Ibu	\N	dewi.3379	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
307	575	Erni Susanti	Ibu	\N	dina.3380	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:23	2026-04-27 09:13:05
1082	588	Supiyah	Ibu	\N	putri.3394	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1084	618	Suparjiani	Ibu	\N	intan.3424	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1086	621	Poniyem	Ibu	\N	lia.3427	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1088	646	Purwanti	Ibu	\N	devi.3308	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1090	656	Ida Pramesti	Ibu	\N	muhammad.3318	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1091	677	Sri Mulyani	Ibu	\N	ahmad.3339	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1093	52	Muslihah	Ibu	\N	azka.3980	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1095	706	Siyam	Ibu	\N	tri.3368	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1097	153	Sutriyanti	Ibu	\N	achmad.3759	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1099	98	Siti Fadilah	Ibu	\N	nabila.3883	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1101	109	Maryana	Ibu	\N	shifa.3894	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
409	119	Wasilah	Ibu	\N	aurora.3904	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:58	2026-04-27 09:13:05
1103	129	Suyatmi	Ibu	\N	dwi.3914	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
779	474	Aprikisanti Rinti Pratiwi	Ibu	\N	galih.3593	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:24	2026-04-27 09:13:06
1249	331	Umoro Estri	Ibu	\N	dina.3620	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
37	50	Sri Wahyuningsih	Ibu	\N	annisa.3978	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:56:42	2026-04-27 09:13:04
1109	281	Parsih	Ibu	\N	muhammad.3710	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1111	296	Fiki Lia Handayani	Ibu	\N	devina.3725	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1113	322	Dewi Rahayuningsih	Ibu	\N	syifa.3749	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1115	208	Partiyah	Ibu	\N	muhammad.3814	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1117	214	Sri Haryati	Ibu	\N	restu.3820	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1119	216	Mei Wulandari	Ibu	\N	syifa.3822	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1120	239	Esti Rahayu	Ibu	\N	ilham.3845	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1122	242	Rofi'Ah	Ibu	\N	muhammad.3848	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1124	415	Nia Agustina	Ibu	\N	muhammad.3534	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
460	437	Sri Mujiati	Ibu	\N	arza.3556	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:16	2026-04-27 09:13:05
1126	439	Parningsih	Ibu	\N	dwi.3558	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1128	452	Suminah	Ibu	\N	muhammad.3571	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1130	454	Lia Nita Indriani	Ibu	\N	nur.3573	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
494	384	Siti Handayani	Ibu	\N	riyani.3674	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:28	2026-04-27 09:13:05
1134	507	Musiti	Ibu	\N	dwi.3456	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1136	527	Supiah	Ibu	\N	tri.3476	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1138	543	Rini Astuti	Ibu	\N	eka.3492	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1140	597	Sugiyati Suparto	Ibu	\N	shifa.3403	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1142	478	Sri Puji Astuti	Ibu	\N	mario.3597	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1144	632	Sumini	Ibu	\N	siti.3438	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
562	643	Rini Noviani	Ibu	\N	casey.3305	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:59	2026-04-27 09:13:05
1146	658	Sumarni	Ibu	\N	muhammad.3320	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1326	235	Triningsih	Ibu	\N	dimas.3841	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
135	240	Kemiyem	Ibu	\N	mahmud.3846	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:19	2026-04-27 09:13:05
1105	148	Sarti	Ibu	\N	sri.3933	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1149	676	Sri Mulyani	Ibu	\N	ahmad.3338	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1151	681	Tukirah	Ibu	\N	arif.3343	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1153	500	Suminah	Ibu	\N	arini.3449	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1155	504	Sutinem	Ibu	\N	dea.3453	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
612	519	Naniek Setyorini	Ibu	\N	medina.3468	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:19	2026-04-27 09:13:05
1157	526	Sutarmi	Ibu	\N	tegar.3475	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1159	535	Triyani	Ibu	\N	aulia.3484	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1161	542	Waginem	Ibu	\N	eka.3491	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1163	545	Kuatminingsih	Ibu	\N	eka.3494	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
639	552	Endang Kurniasih	Ibu	\N	kaira.3501	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:42	2026-04-27 09:13:05
1165	581	Siti Sumiyati	Ibu	\N	intan.3387	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1167	586	Warsi	Ibu	\N	putri.3392	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1169	587	Sulasih	Ibu	\N	putri.3393	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1171	591	Suryati	Ibu	\N	risma.3397	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1175	600	Rubini	Ibu	\N	wahyu.3406	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1177	610	Sujirah	Ibu	\N	azizah.3416	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1179	611	Ponirah	Ibu	\N	bunga.3417	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1181	613	Ngadirah	Ibu	\N	danang.3419	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1183	623	Poniyati	Ibu	\N	meita.3429	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1185	637	Sumaryanti	Ibu	\N	widya.3443	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1187	647	Marniyem	Ibu	\N	dwi.3309	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1189	657	Woro Astuti	Ibu	\N	muhammad.3319	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1191	667	Erlis Tami Maryati	Ibu	\N	rizky.3329	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
1132	356	Any Sutriyaningsih	Ibu	\N	syifa.3645	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
564	645	Juwariyah	Ibu	\N	dandi.3307	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:00	2026-04-27 09:13:05
1193	684	Siti Nurfaida Minarti	Ibu	\N	aulia.3346	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1195	692	Tri Suryati	Ibu	\N	intan.3354	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1197	694	Lia Wahyu Dwi Mulyani	Ibu	\N	muhammad.3356	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1199	695	Heni Setia Budiningsih	Ibu	\N	muhammad.3357	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1201	696	Menik Sunarmi	Ibu	\N	muhammad.3358	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1203	699	Marsini	Ibu	\N	rayhan.3361	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1205	700	Siti Adirotus Solihah	Ibu	\N	riva.3362	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1207	398	Mustika Umiyati	Ibu	\N	aditya.3517	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1209	408	Sri Hartini	Ibu	\N	farkhan.3527	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1211	416	Suhartini	Ibu	\N	muhammad.3535	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1213	419	Siti Muntamah	Ibu	\N	novita.3538	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1215	420	Semirah	Ibu	\N	restu.3539	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1219	424	Wawat Watisah	Ibu	\N	tiara.3543	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1221	426	Dewi Susilowati	Ibu	\N	yanuar.3545	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1223	430	Anisa Listiyani	Ibu	\N	adelia.3549	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1225	431	Siti Rohmah	Ibu	\N	ahmad.3550	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1227	432	Siti Chotijah	Ibu	\N	ahmad.3551	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1229	455	Usriyah	Ibu	\N	raditya.3574	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1231	458	Eka Wardani	Ibu	\N	ridho.3577	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1233	462	Puji Rahayu	Ibu	\N	wahyu.3581	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1235	464	Rusmiyati	Ibu	\N	ahmad.3583	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1237	472	Wastinah	Ibu	\N	dinda.3591	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
327	633	Siti Rubaingah	Ibu	\N	sri.3439	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:30	2026-04-27 09:13:05
566	648	Windarti	Ibu	\N	eko.3310	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:01	2026-04-27 09:13:05
1241	480	Sukini	Ibu	\N	muhammad.3599	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1243	482	Dyah Woro Trimurti Ningrum	Ibu	\N	muhammad.3601	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1245	492	Waginem	Ibu	\N	wahyu.3612	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1247	328	Toyibah	Ibu	\N	aprilia.3616	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1251	332	Rusiyati	Ibu	\N	dini.3621	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1253	336	Khotiah	Ibu	\N	gita.3626	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1255	347	Eka Lestari	Ibu	\N	novita.3637	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1257	350	Nurul Hidayah	Ibu	\N	putri.3640	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1259	359	Fitri Susilawati	Ibu	\N	vika.3648	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1261	364	Sunarti	Ibu	\N	aulia.3653	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1263	369	Siti Fatimah	Ibu	\N	dwi.3658	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1265	376	Paisem	Ibu	\N	nila.3665	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
825	380	Tri Istriyanti	Ibu	\N	reny.3670	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:40	2026-04-27 09:13:06
1267	383	Sulistri	Ibu	\N	riska.3673	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1269	390	Tumini	Ibu	\N	umi.3680	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1271	264	Dwi Prihatin	Ibu	\N	aprilia.3693	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1273	265	Lestari	Ibu	\N	azizah.3694	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1275	270	Musolikah	Ibu	\N	dimas.3699	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1277	290	Daryati	Ibu	\N	syifa.3719	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1279	298	Seniyem	Ibu	\N	eka.3727	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1281	303	Suparti	Ibu	\N	laila.3732	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1283	308	Tantiati	Ibu	\N	muhammad.3737	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1285	319	Sariah	Ibu	\N	salma.3748	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
287	534	Waida Endariasih	Ibu	\N	arvany.3483	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:16	2026-04-27 09:13:05
637	550	Tina Rosmala Dewi	Ibu	\N	icha.3499	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:41	2026-04-27 09:13:05
1217	421	Dwi Supartiyati Ningsih	Ibu	\N	restu.3540	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:06
1289	151	Anik Rumantikawati	Ibu	\N	abi.3757	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1291	152	Heru Susiyati	Ibu	\N	achmad.3758	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1293	17	Wariyati	Ibu	\N	dwi.3945	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1295	39	Simpeni	Ibu	\N	shafa.3967	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1296	164	Juariyah	Ibu	\N	galih.3770	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
919	173	Leginah	Ibu	\N	panji.3779	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:14	2026-04-27 09:13:06
1298	177	Wiwik Umiyati	Ibu	\N	rangga.3783	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1300	178	Sarinem	Ibu	\N	ridho.3784	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1302	190	Tri Maelani	Ibu	\N	akbar.3796	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1304	195	Khomsah Surani	Ibu	\N	daffa.3801	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1306	201	Turiyah	Ibu	\N	galih.3807	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1308	204	Umrotun	Ibu	\N	muhammad.3810	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1310	205	Watinah	Ibu	\N	muhammad.3811	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1312	207	Eniati	Ibu	\N	muhammad.3813	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1314	210	Yudianah	Ibu	\N	rafa.3816	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1316	211	Riyati	Ibu	\N	rafa.3817	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1318	213	Suwartini	Ibu	\N	rayhan.3819	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1322	224	Rofingah	Ibu	\N	ahmad.3830	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1324	231	Suyekti	Ibu	\N	damar.3837	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1328	241	Rita Budiarti	Ibu	\N	muhammad.3847	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1330	244	Sunar Wijiati	Ibu	\N	muhammad.3850	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1332	255	Pangestuti	Ibu	\N	wahyu.3861	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
971	88	Mangiyah Fitriani	Ibu	\N	dianata.3873	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:33	2026-04-27 09:13:06
1336	89	Tutik Nurkayati	Ibu	\N	dinda.3874	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1338	96	Tuti	Ibu	\N	mutiara.3881	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1340	105	Indartik	Ibu	\N	ririn.3890	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1342	111	Ponisah	Ibu	\N	ulfa.3896	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1344	113	Feni Widiyanti	Ibu	\N	zaskia.3898	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1348	117	Sri Asih	Ibu	\N	anis.3902	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1350	120	Tri Utami	Ibu	\N	bekti.3905	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1352	121	Pawiti	Ibu	\N	della.3906	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1354	123	Endang Pujirahayu	Ibu	\N	dina.3908	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1356	137	Surini	Ibu	\N	nabila.3922	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1358	141	Wasilah	Ibu	\N	nur.3926	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1360	150	Binarti	Ibu	\N	umi.3935	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1362	9	Sunartinah	Ibu	\N	amelia.3937	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1364	40	Wafiroh	Ibu	\N	siti.3968	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1366	51	Sri Lasmini	Ibu	\N	ayu.3979	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1020	55	Nuri Apriyani	Ibu	\N	citra.3983	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:51	2026-04-27 09:13:06
1368	58	Partini	Ibu	\N	dinda.3986	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1022	59	Eli Kurniawati	Ibu	\N	erlina.3987	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:51	2026-04-27 09:13:06
1370	64	Ekawati	Ibu	\N	najwa.3992	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1372	65	Wartiningsih	Ibu	\N	najwa.3993	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1374	70	Maryuni	Ibu	\N	saras.3998	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1376	74	Nurhalmi	Ibu	\N	suci.4002	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1040	122	Arum Mulyati	Ibu	\N	devi.3907	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:52	2026-04-27 09:13:04
153	349	Siti Chotijah	Ibu	\N	putri.3639	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:26	2026-04-27 09:13:05
165	279	Siti Amanah	Ibu	\N	lu'luul.3708	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:30	2026-04-27 09:13:05
206	442	Suyatmi	Ibu	\N	galang.3561	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:57:46	2026-04-27 09:13:05
244	508	Nurul Fatimah	Ibu	\N	erlin.3457	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:00	2026-04-27 09:13:05
297	554	Susi Ambarsari	Ibu	\N	karisma.3503	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:19	2026-04-27 09:13:05
301	561	Sukarmi	Ibu	\N	saring.3510	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:21	2026-04-27 09:13:05
343	669	Lasasih	Ibu	\N	susilo.3331	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:36	2026-04-27 09:13:05
383	709	Sumarti	Ibu	\N	zsa.3371	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:49	2026-04-27 09:13:05
393	180	Yuliani	Ibu	\N	rizky.3786	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:58:53	2026-04-27 09:13:05
418	258	Nur Khayatiningsih	Ibu	\N	adella.3687	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 12:59:02	2026-04-27 09:13:05
1107	268	Eti Mulyani Sari Rahayu	Ibu	\N	devina.3697	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:53	2026-04-27 09:13:05
1148	663	Fepri Apsari	Ibu	\N	raihan.3325	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:54	2026-04-27 09:13:05
582	686	Daryati	Ibu	\N	danang.3348	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:07	2026-04-27 09:13:05
616	523	Wantiyem	Ibu	\N	oktavia.3472	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:23	2026-04-27 09:13:05
643	556	Mamik Robiyaningsih	Ibu	\N	mayla.3505	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:43	2026-04-27 09:13:05
657	571	Titik Sudarsih	Ibu	\N	bekti.3376	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:00:49	2026-04-27 09:13:05
733	707	Andrianajati Setyaningrum	Ibu	\N	ulil.3369	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:01:55	2026-04-27 09:13:06
741	401	Turini	Ibu	\N	darelleo.3520	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:01	2026-04-27 09:13:06
767	434	Eni Susanti	Ibu	\N	anandita.3553	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:16	2026-04-27 09:13:06
869	307	Sriminarti	Ibu	\N	mao.3736	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:02:56	2026-04-27 09:13:06
899	29	Khoiriyah	Ibu	\N	naila.3957	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:03:07	2026-04-27 09:13:06
1320	217	Paryatun	Ibu	\N	tegar.3823	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
1346	116	Agus Setyowati	Ibu	\N	alya.3901	$2y$12$q8DVmjFfWfBLYW/TsXNKgOPdG90Q0b1x67Lly5EZPI9pfV0DYCq7W	2026-04-23 13:38:55	2026-04-27 09:13:06
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: penilaians; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.penilaians (id, user_id, nama_siswa, kelas, mata_pelajaran, semester, nilai, komponen, tanggal, keterangan, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: presensis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.presensis (id, tanggal, status, jadwal_id, siswa_id, terlambat_menit, keterangan, created_at, updated_at) FROM stdin;
182497	2026-04-27	Izin	30	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 14:42:52	2026-04-27 14:42:52
182498	2026-04-27	Izin	43	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 14:42:52	2026-04-27 14:42:52
182499	2026-04-27	Izin	327	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 14:42:52	2026-04-27 14:42:52
182500	2026-04-27	Izin	332	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 14:42:52	2026-04-27 14:42:52
182501	2026-04-27	Izin	382	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 14:42:52	2026-04-27 14:42:52
182502	2026-04-27	Izin	392	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 14:42:52	2026-04-27 14:42:52
182503	2026-04-27	Sakit	24	638	0	Auto-sync: sakett (Input oleh Ortu)	2026-04-27 15:10:44	2026-04-27 15:10:44
182504	2026-04-27	Sakit	25	638	0	Auto-sync: sakett (Input oleh Ortu)	2026-04-27 15:10:44	2026-04-27 15:10:44
182505	2026-04-27	Sakit	83	638	0	Auto-sync: sakett (Input oleh Ortu)	2026-04-27 15:10:44	2026-04-27 15:10:44
182506	2026-04-27	Sakit	91	638	0	Auto-sync: sakett (Input oleh Ortu)	2026-04-27 15:10:44	2026-04-27 15:10:44
182507	2026-04-27	Sakit	159	638	0	Auto-sync: sakett (Input oleh Ortu)	2026-04-27 15:10:44	2026-04-27 15:10:44
182508	2026-04-27	Sakit	254	638	0	Auto-sync: sakett (Input oleh Ortu)	2026-04-27 15:10:44	2026-04-27 15:10:44
182509	2026-04-27	Sakit	340	638	0	Auto-sync: sakett (Input oleh Ortu)	2026-04-27 15:10:44	2026-04-27 15:10:44
182510	2026-04-27	Sakit	342	638	0	Auto-sync: sakett (Input oleh Ortu)	2026-04-27 15:10:44	2026-04-27 15:10:44
182511	2026-04-27	Sakit	396	638	0	Auto-sync: sakett (Input oleh Ortu)	2026-04-27 15:10:44	2026-04-27 15:10:44
182512	2026-04-27	Izin	397	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:15:13	2026-04-27 15:15:13
182513	2026-04-27	Izin	398	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:20:10	2026-04-27 15:20:10
182514	2026-04-27	Izin	399	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:20:44	2026-04-27 15:20:44
182515	2026-04-27	Izin	400	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:22:50	2026-04-27 15:22:50
182516	2026-04-27	Izin	401	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:24:47	2026-04-27 15:24:47
182517	2026-04-27	Izin	402	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:25:08	2026-04-27 15:25:08
182518	2026-04-27	Izin	403	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:27:31	2026-04-27 15:27:31
182519	2026-04-27	Izin	404	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:27:55	2026-04-27 15:27:55
182520	2026-04-27	Izin	405	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:32:54	2026-04-27 15:32:54
182521	2026-04-27	Izin	406	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:35:10	2026-04-27 15:35:10
182522	2026-04-27	Izin	407	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:35:31	2026-04-27 15:35:31
182523	2026-04-27	Izin	408	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:38:07	2026-04-27 15:38:07
182524	2026-04-27	Izin	409	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:38:30	2026-04-27 15:38:30
182525	2026-04-27	Izin	410	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:39:10	2026-04-27 15:39:10
182526	2026-04-27	Izin	411	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:39:36	2026-04-27 15:39:36
182527	2026-04-27	Izin	412	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:41:19	2026-04-27 15:41:19
182528	2026-04-27	Izin	413	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:41:40	2026-04-27 15:41:40
182529	2026-04-27	Izin	414	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:43:57	2026-04-27 15:43:57
182530	2026-04-27	Izin	415	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:44:22	2026-04-27 15:44:22
182531	2026-04-27	Izin	416	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:46:15	2026-04-27 15:46:15
182532	2026-04-27	Izin	417	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:46:37	2026-04-27 15:46:37
182533	2026-04-27	Izin	418	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:47:39	2026-04-27 15:47:39
182534	2026-04-27	Izin	419	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:48:03	2026-04-27 15:48:03
182535	2026-04-27	Izin	420	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:51:26	2026-04-27 15:51:26
182536	2026-04-27	Izin	421	410	0	Auto-sync: pergi jalan-jalan (Input oleh Ortu)	2026-04-27 15:51:47	2026-04-27 15:51:47
182537	2026-05-12	Terlambat	423	266	255	\N	2026-05-12 11:15:15	2026-05-12 11:15:15
182538	2026-06-12	Terlambat	424	293	190	\N	2026-06-12 16:10:16	2026-06-12 16:10:16
\.


--
-- Data for Name: qr_sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.qr_sessions (id, jadwal_id, tanggal, token, expired_at, guru_id, status, created_at, updated_at) FROM stdin;
90	411	2026-04-27	dfeb8106-32f3-4b70-835f-96b3feb93b1a	2026-04-26 15:40:40	\N	aktif	\N	\N
72	393	2026-04-27	fbc6a744-4af3-4796-81b8-9b80a74a9cba	2026-04-27 15:01:38	\N	aktif	\N	\N
105	426	2026-06-21	a497a259-ed24-4f3b-b6a2-f74789147767	2026-06-20 17:34:38	\N	aktif	\N	\N
73	394	2026-04-27	7ebcf340-5e88-45ac-8fee-ea5425c7369e	2026-04-26 15:14:12	\N	aktif	\N	\N
75	396	2026-04-27	a6207cd9-dd4c-4b4c-bfa2-1e0e424d8b5b	2026-04-26 15:14:16	\N	aktif	\N	\N
70	391	2026-04-27	a0b9f8a4-a620-44cc-8bd3-338c5886f8ef	2026-04-26 15:14:46	\N	aktif	\N	\N
74	395	2026-04-27	9cbf68fa-ab19-41d0-91c6-9b769d730ac2	2026-04-26 15:14:51	\N	aktif	\N	\N
71	392	2026-04-27	e01e2083-c5bc-4a91-b53f-86c3680cf641	2026-04-26 15:14:55	\N	aktif	\N	\N
106	427	2026-06-21	213b52a4-e33f-4fe6-9252-ca74ea2aacd4	2026-06-21 17:53:59	\N	aktif	\N	\N
76	397	2026-04-27	2a2c0b59-245a-4043-9942-4c2b4dc4ca85	2026-04-26 15:19:56	\N	aktif	\N	\N
78	399	2026-04-27	c221e880-bdb2-4a6a-896d-8687a68d0591	2026-04-26 15:22:35	\N	aktif	\N	\N
77	398	2026-04-27	fec1737e-e973-437b-acb7-172b865b365b	2026-04-26 15:24:31	\N	aktif	\N	\N
79	400	2026-04-27	d949fe29-c29e-4aee-a11c-57b58e9fbeda	2026-04-26 15:24:34	\N	aktif	\N	\N
80	401	2026-04-27	ffec1a51-1f17-47b8-b296-a81fffc30156	2026-04-26 15:27:22	\N	aktif	\N	\N
81	402	2026-04-27	8e982585-f6c1-41bd-8018-34fe7b731267	2026-04-26 15:27:25	\N	aktif	\N	\N
107	428	2026-06-26	8e9e98c0-8f00-4e82-9b18-ce9c227422cd	2026-06-26 10:40:46	\N	aktif	\N	\N
83	404	2026-04-27	3f9334fc-0b22-48ff-aa88-ecaddce430de	2026-04-26 15:32:44	\N	aktif	\N	\N
82	403	2026-04-27	c6bd4a8b-1ec0-4245-a834-86cd42ae85ab	2026-04-26 15:34:59	\N	aktif	\N	\N
84	405	2026-04-27	1a906100-4901-4d5f-bc1d-855ecab5be66	2026-04-26 15:35:03	\N	aktif	\N	\N
85	406	2026-04-27	bd2ccc4d-8a41-46dc-9e5e-b1a998e8a023	2026-04-26 15:37:31	\N	aktif	\N	\N
86	407	2026-04-27	cdb24dea-8890-4a97-84c2-320b44e3bbd2	2026-04-26 15:37:34	\N	aktif	\N	\N
87	408	2026-04-27	5c389b82-59bf-4968-87d1-817dfa09d1a1	2026-04-26 15:38:54	\N	aktif	\N	\N
88	409	2026-04-27	e170eb10-5581-412d-94fa-08025a888f31	2026-04-26 15:38:57	\N	aktif	\N	\N
89	410	2026-04-27	1f06ec94-13cc-43cb-9e06-b1e699ff31de	2026-04-26 15:39:24	\N	aktif	\N	\N
91	412	2026-04-27	8c465446-8480-4440-9430-64dd41a1e685	2026-04-26 15:41:29	\N	aktif	\N	\N
92	413	2026-04-27	ad499c2f-f044-48b3-9ec6-e13691e714c8	2026-04-26 15:42:06	\N	aktif	\N	\N
93	414	2026-04-27	18808b9b-51fc-4f72-a5cc-9a85e3a5ef0d	2026-04-26 15:44:09	\N	aktif	\N	\N
94	415	2026-04-27	d7d7c94b-8950-42b5-9489-3745ce1a8ece	2026-04-26 15:46:09	\N	aktif	\N	\N
95	416	2026-04-27	acfa58b2-2076-4f8f-9696-25c9ba2ff045	2026-04-26 15:46:26	\N	aktif	\N	\N
96	417	2026-04-27	3d89c74e-2061-4495-9a0f-73c7ac6cf7b3	2026-04-26 15:47:32	\N	aktif	\N	\N
97	418	2026-04-27	0385723c-66bb-4ea1-a301-69db4dcd9ad4	2026-04-26 15:47:52	\N	aktif	\N	\N
98	419	2026-04-27	e6cd39f5-6376-4e52-a53b-7f3a0c8c81d1	2026-04-26 15:51:19	\N	aktif	\N	\N
99	420	2026-04-27	48ae36a3-9f64-4165-8c71-2d169f8249e8	2026-04-26 15:51:36	\N	aktif	\N	\N
100	421	2026-04-27	6abe1edf-ae6e-479e-a209-c37e24af0501	2026-04-26 16:47:33	\N	aktif	\N	\N
101	422	2026-04-27	d10d74e4-fcfd-46f5-8dae-27fd38099adc	2026-04-27 17:11:14	\N	aktif	\N	\N
102	423	2026-05-12	b4438b99-0095-4685-addf-cc4619bfd724	2026-05-12 11:48:22	\N	aktif	\N	\N
103	424	2026-06-12	b2e3f966-fe8d-4934-bef3-2a14e8460204	2026-06-12 16:11:21	\N	aktif	\N	\N
104	425	2026-06-20	adca3de9-6988-4cbf-a72a-4a8eef6e484b	2026-06-20 13:27:18	\N	aktif	\N	\N
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
jDTW7dHohO4h7YWgTB6pTijpyghPqqDjAz0zeRP0	11	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36	eyJfdG9rZW4iOiIwV1NhOU8zSmdNa0NWUllLZkpUSjhERUgydVBlTXA5OHVFS2c4Z2EzIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xhcG9yYW5cL3Jla2FwLWhhcmlhbj9rZWxhc19pZD03JnRhbmdnYWw9MjAyNi0wNi0yNiIsInJvdXRlIjoibGFwb3Jhbi5yZWthcF9oYXJpYW4ifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjExLCJsb2dpbl9yb2xlIjoicGlrZXQifQ==	1782447290
lexovLDJ5yLFqmb3gYuDPn82ORcgucKu62A3NeAP	\N	127.0.0.1	Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1	eyJfdG9rZW4iOiJxRjVGUkFVTzhCS0w2TGFwZUFZRFF4T0ZRUkZTTzd0dEx2ZjZNNDhCIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==	1782455294
FNHDPuBehDIzEizgdlTF1bCLJ4eLhjR9CLrdcg6J	\N	127.0.0.1	Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1	eyJfdG9rZW4iOiJIVjB6OWt6WDQxZ01tMnlUcWVobzl2NWU5WUh5czdqekl5NzZnUnVjIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==	1782455304
wQo9WqteOLcHqhweZ9z8B6nWNpHZvcxDwwrGNmTP	11	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36	eyJfdG9rZW4iOiJ3UFRJbTIyZ1ZEWjQyT0hYM09kaGtwcFZ4SGdJTDNKdXdOcm1GMVRhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wcm94eVwvcGhvdG9cLzExIiwicm91dGUiOiJwaG90by5wcm94eSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxMSwibG9naW5fcm9sZSI6Imd1cnUifQ==	1782611620
\.


--
-- Data for Name: siswas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.siswas (id, nama, kelas_id, user_id, username, password, nis, nisn, jk, tempat_lahir, tgl_lahir, nik, agama, alamat, nama_ayah, nama_ibu) FROM stdin;
84	Aspasia Iffatha Benita	4	\N	aspasia.benita	$2y$12$sQeHv7buDC4kVo/DQakA2uunbH0lTd3V7NRrkk2AYlfqavWBeOpyW	3869		P		\N					
87	Devita Airinnisa	4	\N	devita.airinnisa	$2y$12$61vfZtLlnS1QNcJe5B2hCOSBAD0FhOB.s5smQ6dJlrdOcfDP5m8xm	3872	98430787	P	Purworejo	2009-12-16	3306045612090001	Islam	RT 4/RW 1 Krajan Lor Desa/Kel. Piji Kec. Bagelen	Sugiyanto	Marwiyanti
8	Alifatun Naila	6	\N	alifatun.naila	$2y$12$cCl4zvyC/vvmYa.ygfoYkOn6FnEfvTrj3TsLFJRXDLZ7C20wBhXxa	3936	109822571	P	Tanggerang	2010-05-21	3206146105100002	Islam	RT 1/RW 2 Sembir Somorejo Kec. Bagelen	Zenal Abidin	Mistini
10	Andrias Muh Kajat	6	\N	andrias.kajat	$2y$12$Mq44F1S5x47spVNMO5Ll0eM6HQxZ3ZLheAtHeCGE6w9anL/K2f36i	3938	94538786	L	Purworejo	2009-11-07	3306040711090001	Islam	RT 1/RW 2 Krajan Kidul Piji Kec. Bagelen	Sarto	Pilah
12	Aulia Ramadhani	6	\N	aulia.ramadhani	$2y$12$WV8RoSup7d18dhsWjpvt/uiBkrq4CCzMNXwqLoeuT0JnQ7pF6Wcc6	3940	96009985	P	Purworejo	2009-08-24	3306046408090001	Islam	RT 25/RW 5 Metro Kec. Metro Pusat	Ari Wibowo	Darwati
14	Aviva Setyowati	6	\N	aviva.setyowati	$2y$12$ZJBwxcSSe3Eftyj3SqSt.u0PfYDSRhTUwK61iTh3LG8uQhP8Zn5CG	3942	95155537	P	Purworejo	2009-11-04	3306064411090001	Islam	RT 2/RW 6 Makemdowo Desa/Kel. Sido Mulyo Kec. Purworejo	Slamet Sriyono	Ari Susilowati
16	Devi Indah Lestari	6	\N	devi.lestari	$2y$12$rDtm1/WC3Evb2f7AGdDbKe9nbvUAy1rkYoTPejyVkTIFNV6c5nNUS	3944	102432752	P	Purworejo	2010-01-22	3306066201100001	Islam	RT 2/RW 4 Cocolan Desa/Kel. Pacekelan Kec. Purworejo	Paryono	Tutik
18	Dwi Priyanto	6	\N	dwi.priyanto	$2y$12$YG29ULUTKpm0iuXWoQVgmOXl//uPytm81zVZjTQv4JdqM6SK8GKmO	3946	109669991	L	Purworejo	2010-12-23	3306062312100001	Islam	RT 1/RW 1 Wirosaran Desa/Kel. Sudimoro Kec. Purworejo	Supangat	Legirah
20	Elza Banowati	6	\N	elza.banowati	$2y$12$.h7crBayMXbavv5MN/WaYuyhj29uyFuCX7fla69T/Uo1DQRZCVezy	3948	104310977	P	Purworejo	2010-05-09	3306054905100001	Islam	RT 4/RW 1 Krajan Somongari Kec. Kaligesing	Wakidi	Tri Mulyani
22	Haniifah Ayu Ashim	6	\N	haniifah.ashim	$2y$12$lA6dwgnkbwXj6L7xoqKXK.tMq7K6O7ZOV4ikvIBDjE2i3HL/mHWE.	3950	105478596	P	Purworejo	2010-08-22	3306056208100001	Islam	RT 5/RW 2 Krajan Desa/Kel. Jatirejo Kec. Kaligesing	Supriatin Eko Santoso	Nurkhasanah
24	Intan Eka Riana	6	\N	intan.riana	$2y$12$4.cRft/vcHQeTXtIeNO/JeYnxSkRIwqXeQsrFRPBR2cyzV2lsBfOi	3952	102898881	P	Purworejo	2010-07-09	3306044907100002	Islam	RT 5/RW 4 Sejagir Desa/Kel. Somorejo Kec. Bagelen	Teguh Basuki	Nuryani
26	Lusia Mariya Putri Rohani	6	\N	lusia.rohani	$2y$12$TEiznjYkPw8xBQ0O/sWG8.UtGdY2.odFHUzp/zuFj8pb2dGRf3Soq	3954	3093466660	P	Purworejo	2009-08-07	3306054708090002	Katholik	RT 0/RW 0 Desa/Kel. Purworejo Kec. Purworejo	Agustinus Jajag Wahyu Setiawan	Puji Rohani
28	Nabila Azahra	6	\N	nabila.azahra	$2y$12$Q6HRNb61iDRQwZx39NIIV.HmmiKG6i8GZptGwxcaP9YGT1pYkVgIC	3956	108316186	P	Purworejo	2010-04-15	3306065504100002	Islam	RT 3/RW 2 Desa/Kel. Plipir Kec. Purworejo	Wagiman	Suprihatin
32	Octa Widadatul Uhliya	6	\N	octa.uhliya	$2y$12$Ab5tAprZ8O31OGy2OKXdh.zWSaazUqrwpU8rgICJS.Ex8Jdb8deFm	3960	98725447	P	Purworejo	2009-10-21	3306066110090002	Islam	RT 1/RW 12 Desa/Kel. Tambakrejo Kec. Purworejo	Tumaryono	Dwi Fitri Lestari
35	Risma Putri Anggraeni	6	\N	risma.anggraeni	$2y$12$5vKfjsg7oq.aREe8zmBfUOgHkjKo76zavKJgCpbo70b.aNTLMn5Iq	3963	95379250	P	Purworejo	2009-10-19	3306045910090001	Islam	RT 1/RW 5 Jolotundo Desa/Kel. Kemanukan Kec. Bagelen	Narto	Sumarni
38	Senandung Sekar Widati	6	\N	senandung.widati	$2y$12$vS5iDVh5xK5dr7mfnEhITuEN1qzn/zcGD38GdUXyKqIsPKZ/baXOy	3966	108693683	P	Bekasi	2010-07-10	3216195007100003	Islam	RT 5/RW 12 Sukadami Sukadami Kec. Cikarang Selatan	Budhi Sakiarto	Sri Wahyuningsih
42	Vika Dwi Saputri	6	\N	vika.saputri	$2y$12$CijpTTy4e8O3JbqATAsv2u9QIcBcyhUtCzIHS3tkV7PUtWO6.Hp7q	3970	109229144	P	Purworejo	2010-07-12	3306065207100001	Islam	RT 2/RW 8 Babahan Sidomulyo Kec. Purworejo	Sudiyo	Widaryani
43	Widya Citra Fitri	6	\N	widya.fitri	$2y$12$HgY3Qrg9E6X7D9QfkY1pCOzAeuT02XYHs851MNOizm9r0PGBxLhi6	3971	96966039	P	Purworejo	2009-10-09	3273064910090003	Islam	RT 6/RW 3 Pajajaran Kec. Cicendo	Widaryanto	Dian Maryanti
48	Andhika Romadhon	7	\N	andhika.romadhon	$2y$12$2gdWjRYESPLCfhCOWqMOEOl322f0PyPepzzLnrZBXo6aINpB5XYiy	3976	89123574	L	Purworejo	2008-09-13	3306041309080002	Islam	RT 4/RW 3 Kibon Piji Kec. Bagelen		Yatinah
50	Annisa Nur Ana	7	\N	annisa.ana	$2y$12$9mERO3Zl7SyUWMncrh3mSOxOX3VntIn8N3CHE2Q/xtAvUNzwBDph2	3978	92168688	P	Purworejo	2009-11-17	3306045711090001	Islam	RT 2/RW 1 Plarangan Rt 002 Rw 001 Hargorojo Bagelen Desa/Kel. Hargorojo Kec. Bagelen	Rusiman	Sri Wahyuningsih
53	Berliana	7	\N	berliana	$2y$12$jgEyS2g6IVnY2gGzh7JwHuMlpyW16uAL4SDLcnCZ6KNgQ5NGFNS4e	3981	106119800	P	Jakarta	2010-05-01	3306044105100001	Islam	RT 1/RW 1 Clapar Kidul Desa/Kel. Clapar Kec. Bagelen	Wasgono	Poniyati
56	Dea Delphiana	7	\N	dea.delphiana	$2y$12$NZEKBCnxoTclbKu2ZKKzjew6Zedd/Ck62XdKNwKUf0xRiCnjVWwOa	3984	98665253	P	Purworejo	2009-11-20	3271056011090006	Islam	RT 4/RW 5 Boro Kulon Kec. Banyu Urip	Yopan Dwijo Pratomo	Yanuar Handayani
60	Irna Safitri	7	\N	irna.safitri	$2y$12$vTKXMFvEsoKbOjpLlJsX9OJ7.IyCIrNNffhSrYioCFdHbdwdnA.MG	3988	94967535	P	Purworejo	2009-12-24	3306056412090002	Islam	RT 3/RW 3 Sewu Desa/Kel. Kedunggubah Kec. Kaligesing	Marsudi	Urip
63	Meyka Tata Wahyuni	7	\N	meyka.wahyuni	$2y$12$ePPAdZLQ0FFz7FN.yYyx6OetKCY7mVIJj5NhMPZSjpAEyzXbnOrX.	3991	94285731	P	Purworejo	2009-05-08	3306054805090002	Islam	RT 7/RW 1 Katerban Donorejo Kec. Kaligesing	Eli Wahyudi	Komaisih
66	Novia Nanda Setianingrum	7	\N	novia.setianingrum	$2y$12$s2o4tyAJStrfbUUZXog2MOmW2Gq2B04DXq/JeaSvOragV1R2qO/Wa	3994	105672463	P	Purworejo	2010-11-09	3306054911100001	Islam	RT 4/RW 4 Rejosari Donorejo Kec. Kaligesing	Sarjan	Sugiyanti
69	Sarah Rahmawati	7	\N	sarah.rahmawati	$2y$12$a5hDPuvrEzN9Gk3YPc753O6U/RS/s7wkV52nc6votD0Bg5kwTyUJW	3997	104755340	P	Purworejo	2010-03-31	3306037103100001	Islam	RT 3/RW 1 Ponogaran Jenar Lor Kec. Purwodadi	Kuci Sukmana	Warningsih
73	Siti Mutmainah	7	\N	siti.mutmainah	$2y$12$Y.PrHpCcAB9AK/azCCJ9FOju4gPW3kxDDyzEglqLKdfMRQtER9GG6	4001	98627725	P	Purworejo	2009-12-24	3306056412090003	Islam	RT 7/RW 1 Katerban Donorejo Kec. Kaligesing	Suparmanto	Sutinem
76	Ulina Octaviani	7	\N	ulina.octaviani	$2y$12$DAcawe.uGlnvvg4oKPAXue8HjfCk7GvJNZ9SchwjSieEhaZeYKBjW	4004	3096889911	P	Purworejo	2009-10-08	3306064810090001	Islam	RT 1/RW 3 Sidomulyo Kec. Banyu Urip	Jajang Oji	Anik
154	Aditya Syarif Al Mahfudhoh	1	\N	aditya.mahfudhoh	$2y$12$SaJD2Bokc2fNYrurZfLESugckuiGvBuGiVXx.phTSJ8aeHC8DvU2.	3760	101639246	L	Wonosobo	2010-05-28	3306152805100001	Islam	RT 3/RW 1 Maron Maron Kec. Loano	Budiyono	Sunting Utami
157	Azam Dafa Pratama	1	\N	azam.pratama	$2y$12$h/TCyOFSVi2DCWQBfMSKEe9AnfIPtlq6lOtaC/CdDxoZ.9Agrt.iW	3763	97100143	L	Purworejo	2009-09-09	3306060909090006	Islam	RT 1/RW 3 Karangrejo Desa/Kel. Paduroso Kec. Purworejo	Suparman	Wiji Lestari
160	Deva Wibowo Widianto	1	\N	deva.widianto	$2y$12$ocBR3KWUtUDOFUuBkHdQXOHHVJg741Hs6ZB3.D33XsoRa08ioKhKG	3766	91919765	L	Purworejo	2009-02-07	3306060702090002	Islam	RT 2/RW 1 Krajan Somongari Kec. Kaligesing	Wagiono	Turini
163	Fath Khurohim	1	\N	fath.khurohim	$2y$12$5195BYbrI6yf8a6hySG2l.tKDL1ZgDNKrS8jXBkD0NNkv9nlfwyje	3769	95755268	L	Purworejo	2009-03-02	3306060203090002	Islam	RT 3/RW 5 Nasaran Desa/Kel. Cangkrep Lor Kec. Purworejo	Muh Basroni	Tukinem
167	Heksa Rakanianto Pratama	1	\N	heksa.pratama	$2y$12$lxFjI9fEBTSExVFhvP8kSezAmyWNF.KHe8sP.Mgli0b2u318DraYy	3773	84675764	L	Purworejo	2008-06-21	3306042106080001	Islam	RT 1/RW 1 Semono Semono Kec. Bagelen	Hidayah	Hidayah
170	Marvin Hidayat	1	\N	marvin.hidayat	$2y$12$WNuOc2EVSVLBFZjcLV589eCxn80i8g8KfjTm53s8O1nn7zDxDp7xu	3776	99102438	L	Purworejo	2009-03-25	3306042503090001	Islam	RT 1/RW 4 Piji Piji Kec. Bagelen	Sugiono	Daryati
172	Nova Dzahwan 'Ammar	1	\N	nova.ammar	$2y$12$PnwPA5Rf7GtZqRsEDLjQFOyq/uPMC4uedBXTkvog/Oqm4UTPHLZGO	3778	94576512	L	Purworejo	2009-11-07	3306120711090001	Islam	RT 2/RW 1 Ketaon Girijoyo Kec. Kemiri	Walyono	Nasiati
176	Rafka Nafirsa Saputra	1	\N	rafka.saputra	$2y$12$O2Q1v1ydqk275k8LGcoTnu.zjNh/mzol07H2AY3vrRs4237vV1y2K	3782	106450792	L	Purworejo	2010-01-29	3306052901100001	Islam	RT 6/RW 1 Katerban Donorejo Kec. Kaligesing	Tulus Saputro	Musyarofah Indaryani
179	Rizki Romadhon	1	\N	rizki.romadhon	$2y$12$usHIe/6VK7i1sTB8L2zDluH7QrCnDgJcJhlCNfU/XDFBPhXk.izU2	3785	98671426	L	Purworejo	2009-08-25	3306042508090001	Islam	RT 2/RW 1 Krajan Lor Piji Kec. Bagelen	Slamet	Tuminah
90	Dwi Yuli Astuti	4	\N	dwi.astuti	$2y$12$jW7ESAlfOYY1x9H7WYZqF.AQW9zvWj2FNaToOasY.iPpNHv5Swpcy	3875	96988575	P	Purworejo	2009-07-10	3306065007090001	Islam	RT 1/RW 3 Jurangjero Desa/Kel. Sidorejo Kec. Purworejo	Pono	Parmi
94	Kristina Anggraeni	4	\N	kristina.anggraeni	$2y$12$52BN4WO4np5ZLTCLgkkANe2DN9Xa8doWsBBIxHjoOgC/Xv6Z8WHmC	3879	102893369	P	Purworejo	2010-05-15	3306055505100001	Kristen	RT 1/RW 3 Denansri Donorejo Kec. Kaligesing	Andi Ristanto	Tutik Ruslamdari
97	Nabila Artchika Putri	4	\N	nabila.putri	$2y$12$f0pnbLaZdGZalhxTHDkb4OenKIk69326sakb8M1rQoj2FXuWBFv7e	3882	108861492	P	Purworejo	2010-05-31	3306047105100002	Islam	RT 3/RW 3 Karang Sari Desa/Kel. Kemanukan Kec. Bagelen	Sutatok Prayogo	Sri Lestari
100	Nadira Aulia Mardiyani	4	\N	nadira.mardiyani	$2y$12$F8HCB8mM1u6epsL31HX8POvEspdv75jdxKEHcv/xen67neL3DVrDC	3885	85461016	P	Purworejo	2008-10-13	3306065310080003	Islam	RT 1/RW 2 Wonotulus Kec. Purworejo	Mardiyono	Aprilia Ermawati
103	Nia Haryanti	4	\N	nia.haryanti	$2y$12$p3WKfejPLTRzuhZBi3QstOga9DAZYFx8ci/W4bhCBD3Byratwz5Xm	3888	102534817	P	Purworejo	2010-02-14	3306045402100001	Islam	RT 2/RW 5 Setoyo Hargorojo Kec. Bagelen	Ponidi	Eka Haryati
107	Salsa Anandita Ramadani	4	\N	salsa.ramadani	$2y$12$vvpAosgb1kuAcPheydgnLemp5D9LO939rKPz0U9kXmSTOSfCujukm	3892	3105008438	P	Tanah Abang	2010-08-31	1502067108100001	Islam	RT 2/RW 0 Sidomulyo Sido Mulyo Kec. Purworejo	Urip	Ramini
110	Tiara Aisyahri Husna	4	\N	tiara.husna	$2y$12$CSWPdIsGWTR7FkiXAeBTB.VHdm058KZLsnrS7Zr148MoEo9MqpmAG	3895	103097901	P	Purworejo	2010-03-30	3306067003100001	Islam	RT 1/RW 4 Gandasari Kec. Jati uwung	Surwanto	Sarminah
112	Wiji Wijayanti	4	\N	wiji.wijayanti	$2y$12$BntX8qeAmNL.mqoWmomjF.jk0arnuNqiYn9zVytDECCV70NPS7KIK	3897		P		\N					
115	Alifa Cahyana	5	\N	alifa.cahyana	$2y$12$d3HkA2M0/DPq7g/bDmKF5eus1gTFJultXTkUpysJCJQ8M8SEOcAei	3900	109704775	P	Purworejo	2010-06-27	3306046706100001	Islam	RT 2/RW 6 Mejing Desa/Kel. Somorejo Kec. Bagelen	Sutarto	Rika Artanti
118	Annisa Nawal Rochimah	5	\N	annisa.rochimah	$2y$12$PUS0bWAsMD91lvuqf.VHwOHGe0OdZRAbxwgE36bwrVpcJmC9UTwSe	3903	109733802	P	Purworejo	2010-01-01	3306054101100002	Islam	RT 2/RW 5 Dukuhrejo Somongari Kec. Kaligesing	Harjono	Mariyah
122	Devi Diah Prasetyawati	5	\N	devi.prasetyawati	$2y$12$2gCal1wrQ3c3z8cwBeFCqeT3pexD8MIgMFNOexYMYKANhb9SR7Qly	3907	93901162	P	Purworejo	2009-12-07	3306064712090001	Islam	RT 1/RW 2 Kedung Sari Kec. Purworejo	Kusno	Arum Mulyati
125	Dini Nur Septiani	5	\N	dini.septiani	$2y$12$QuM9alefu/RFBH21UtImdOBhBmKj/rN7ht5VCD7ZBzsVkme9GsX02	3910	106105051	P	Purworejo	2010-09-25	3328106509100003	Islam	RT 3/RW 1 Sumur Wayang Desa/Kel. Plipir Kec. Purworejo	Sunarto	Darwati
128	Dwi Indra Prastiwi	5	\N	dwi.prastiwi	$2y$12$ylJu7jIA8.7rI03v3efjOufdBlKhbHUWA34kVriMTl196UaDK3ESu	3913	102779634	P	Purworejo	2010-05-06	3306044605100001	Islam	RT 5/RW 2 Kahuripan Rt 005 Rw 002 Desa/Kel. Kalirejo Kec. Bagelen	Bambang Partono	Sugiyanti
132	Meita Laras Setiawati	5	\N	meita.setiawati	$2y$12$fa4VqGOqvlYGQ.AM2i7UF.j6wNMYCNRLNMcPLNYznG0N5WZiGKRM2	3917	63428951	P	Purworejo	2006-05-07	3306044706060001	Islam	RT 1/RW 5 Kemanukan Kec. Bagelen	Paidi	Endah Larasati
135	Mita Wijayaningsih	5	\N	mita.wijayaningsih	$2y$12$Euj29jTZhTLWH3Ov3FNmm.X78Q10wPRe.IjeSaK2hyFMAOv6Tt52W	3920	106373673	P	Purworejo	2010-01-30	3306047001100002	Islam	RT 1/RW 2 Sangkalan Rt 001 Rw 002, Bapangsari, Bagelen Desa/Kel. Bapangsari Kec. Bagelen	Prayogo	Saryati
138	Nafisah Zain	5	\N	nafisah.zain	$2y$12$2PFAuVMwEzYudu1Xjdqle.p6GmES1ACVwuJcrFaoZLjTBzvog..wG	3923	109100387	P	Purworejo	2010-04-05	3306064504100001	Islam	RT 4/RW 2 Krajan Kedung Sari Kec. Purworejo	Faqur Rohman	Umi Kulsum
142	Nurul Fathonah	5	\N	nurul.fathonah	$2y$12$MyqsiywwGulyEk8pzW3PEOY.K3rrVarCo7LoU4alUSFHrwSF73P4C	3927	102238799	P	Purworejo	2010-04-07	3306044704100001	Islam	RT 3/RW 4 Karangrejo Desa/Kel. Kemanukan Kec. Bagelen	Darmono	Poniyem
145	Selfira Choirunnisa'	5	\N	selfira.choirunnisa	$2y$12$zIqXD9XanYVJ5DegrCfPIu/FihGAoQS/TAqNAfAF6D7zlJsMTpU9O	3930	95125461	P	Magelang	2009-11-02	3308024211090001	Islam	RT 1/RW 1 Dukuh Popongan Kec. Banyu Urip	Makmuri	Endriyanti
149	Tiara Nurjanah	5	\N	tiara.nurjanah	$2y$12$CRo9aMEM3aTOC76VYS6zk.cGXAIh1fbpqJv/.sgrM1BaTVT417KEe	3934	99508674	P	Jakarta	2009-01-09	3175064901090005	Islam	RT 1/RW 5 Tepus Rt 001 Rw 005, Somorejo, Bagelen Desa/Kel. Somorejo Kec. Bagelen	Suyatno	Maniek Vina Ismawati
261	Anaya Rasya Kania	13	\N	anaya.kania	$2y$12$z5xsX2okPKuGLOVW.1G/IuBC4.7guFrWUKIpmSYoQ6UP4HPLoilEi	3690	99474105	P	Sukoharjo	2009-02-27	3306066702090005	Islam	RT 2/RW 1 Jambul Brenggong Kec. Purworejo	Suroso	Murbaniyah
263	Annisa Agustina	13	\N	annisa.agustina	$2y$12$ArYLPk7y2Yji6z6r9h72Y.ZFaYZLiJ8PR8FhdNNsJoVlo3itNXbvq	3692	92375195	P	Purworejo	2009-08-08	3306044808090001	Islam	RT 1/RW 2 Krajan Kidul Piji Kec. Bagelen	Budiarto	Suprih Susanti
266	Azka Shofiana	13	\N	azka.shofiana	$2y$12$QvEO5EELhoTY/qDsSG21muflqWGHxWQxuWQxRQ1AwQUFugb5BAfOC	3695	89776767	P	Purworejo	2008-08-04	3306044408080001	Islam	RT 2/RW 1 Plarangan Hargorojo Kec. Bagelen	Nanang Kosim	Eka Eramaya
269	Devina Rahayu	13	\N	devina.rahayu	$2y$12$AbHmJDfeuhl8zFYZn70DB.0vsDIDaS0C3GYs3udqbsL09V7BSOEQ6	3698	93454221	P	Purworejo	2009-01-21	3306066101090001	Islam	RT 0/RW 0 Sidomulyo Desa/Kel. Sido Mulyo Kec. Purworejo	Ponidi	Warsinem
182	Siti Aulia Rahmafuri	1	\N	siti.rahmafuri	$2y$12$z0Hb62dwtfvBaBNp4i0BeeoeiNdZGAyFCiZ4hHu4U9rLwIhNZLws6	3788	102340889	P	Purworjeo	2010-04-07	3306154704100001	Islam	RT 1/RW 2 Rimun Kec. Loano	Slamet Riyanto	Siti Jamilah
186	Abi Achmad Rizki	2	\N	abi.rizki	$2y$12$EnNuu2U.g0icKZxBc8eVdu5hQBOycojDCusa96UQd47lIoWPQMgWu	3792	93841154	L	Purworejo	2009-11-26	3306042611090001	Islam	RT 8/RW 1 Keposong Rt 009 Rw 001, Kalirejo, Bagelen Desa/Kel. Krendetan Kec. Bagelen	Wagisan	Rinah
189	Aiful Ahmadi	2	\N	aiful.ahmadi	$2y$12$59KOfi.7m7WKBWTFJmJk6ejm4JYGxB09Tuu7YxBRhWkFUlPMwPXRu	3795	91547429	L	Purworejo	2009-05-16	3306041605090001	Islam	RT 2/RW 4 Gumuk Piji Kec. Bagelen	Nur Fauzin	Suheri
192	Ari Febrianto	2	\N	ari.febrianto	$2y$12$YtGZRD1fEVjFR3C4.5BJ3.gWGi1N0xhe4X0sXeTHd3TIaSsK0FhsC	3798	101328464	L	Purworejo	2010-03-20	3306062003100002	Islam	RT 2/RW 2 Kemandungan Desa/Kel. Wonoroto Kec. Purworejo	Rastanto	Sawitri
196	Dygta Pratama	2	\N	dygta.pratama	$2y$12$E1H.bIXy89ZUDXKHsp3Ae.p8kk/oG.rERD04A4Z/r1OE0BCbaKWcS	3802	81112682	L	Purworejo	2008-03-07	3306040703080001	Islam	RT 2/RW 5 Jolotundo Desa/Kel. Kemanukan Kec. Bagelen	Sutrisno	Kasmi
199	Fauzul Aziz	2	\N	fauzul.aziz	$2y$12$d5QyzS6lud/V/PAPtQlf3.6YQRcqp9X4WGFHy40vMBUXIY/ulji9m	3805	94354570	L	Purworejo	2009-10-30	3306033010090001	Islam	RT 1/RW 2 Desa/Kel. Sidoharjo Kec. Purwodadi	Infak Khamidina	Rojanah
202	Halimatus Sa'Diyah	2	\N	halimatus.sadiyah	$2y$12$zJwkAEpMTKdWhbVYJz/0Nu4AYbWvL5waKnzBQJq3/ru1V3BgNQI0G	3808	101733970	P	Purworejo	2010-02-13	3306155302100001	Islam	RT 2/RW 2 Krajan Lor Desa/Kel. Rimun Kec. Loano	Amad Yahya	Siti Maesaroh
206	Muhammad Rafi	2	\N	muhammad.rafi	$2y$12$WHlBGGYRv9nBmEH2BqGq1ut/IoiW51zaQDrV2t9tn212LkVvroIRm	3812	91129945	L	Purworejo	2009-06-21	3306162106090001	Islam	RT 2/RW 4 Karang Duwur Desa/Kel. Cangkrep Lor Kec. Purworejo	Mustofa	Supriyati
209	Muhammad Zidnie Maulana	2	\N	muhammad.maulana	$2y$12$p2IGiEaQtRGkTe3sUnf3YuAAT/qazMpnfs/jDJz.2CPkJT/LX5fSC	3815	109959436	L	Brebes	2010-02-20	3329062002100001	Islam	RT 1/RW 3 Jeketro Kaligono Kec. Kaligesing	Achmad Ikhsan	Satriyati
212	Raihan Abdurrohman	2	\N	raihan.abdurrohman	$2y$12$c0D0w4aWshsG2eiMrJa6duL.12J6l1cys3/fpSNkkOMaPfQJ4pcia	3818	103603469	L	Purworejo	2010-04-30	3306043004100001	Islam	RT 4/RW 1 Keposong Desa/Kel. Kalirejo Kec. Bagelen	Setiyono	Supriyani
215	Rivta Maulana Putra	2	\N	rivta.putra	$2y$12$jBoMuqSX8S7ogd3NPkMqWOHAdCC7sgfddqd4dcoezTIU7KI7P4ECe	3821	93582083	L	Purworejo	2009-03-31	3306063103090001	Islam	RT 1/RW 1 Desa/Kel. Wonotulus Kec. Purworejo	Sumarno	Sulinah
218	Tri Kurniaputra	2	\N	tri.kurniaputra	$2y$12$WAN0rmCbP8FvAzW5XSE2bus.BXSjX4JjwdEtm/mtZ06SdkGsXkZPq	3824	92453395	L	Purworejo	2009-07-08	3306050807090001	Islam	RT 5/RW 3 Sawahan Somongari Kec. Kaligesing	Waryono	Fani Nurmawati
220	Zaidan Arya Saputra	2	\N	zaidan.saputra	$2y$12$SsmhPIiVVnOPKweRH4Z6WuTugmBXMT3qUtwHYQOuKlC1virG1M4Qu	3826	109943191	L	Kebumen	2010-06-17	3305141706100001	Islam	RT 1/RW 10 Baledono Kec. Purworejo	Bambang Supriatno	Muji Rahayu
223	Ahmad Nur Dian Isnaini	3	\N	ahmad.isnaini	$2y$12$BnunTNWW7r/qN7zDS3icZOEzQ5mx/1bpLqfDyo/JxDE/gAcRFb/8K	3829	79597897	L	Purworejo	2007-07-23	3306062307070002	Islam	RT 4/RW 2 Tegalrejo Desa/Kel. Ganggeng Kec. Purworejo	Syahid	Sutini
227	Annas Saifulloh Fata	3	\N	annas.fata	$2y$12$FtTP800UTaTJ7XIVKbLX7ekob8nzdamYduSU5TExjcr6oFDLtDcJm	3833	94076594	L	Purworejo	2009-05-19	3306061905090002	Islam	RT 5/RW 8 Baledono Krajan Baledono Kec. Purworejo	Arachman	Sri Widayanti
230	Charisma Nilna Nafiza	3	\N	charisma.nafiza	$2y$12$DL.8bT6iVdFDrGFGBV4eKuZ2FKYSTOy/nCJrYhJVAdsbqTCruLUcm	3836	99030552	P	Purworejo	2009-08-27	3306126708090002	Islam	RT 2/RW 1 Ketaon Girijoyo Kec. Kemiri	Ngadiman	Iswati
233	Destina Tejasvini	3	\N	destina.tejasvini	$2y$12$DAHP.6VEgcxknvPo0kFGj.Wyl/R7jj/gvOEpQO6oXk9oubVZ5bVxK	3839	108204806	P	Purworejo	2010-12-22	3306046212100001	Islam	RT 1/RW 2 Mojosongo Soko Kec. Bagelen	Ponimin	Tri Setyaningsih
236	Fani Agus Prianti	3	\N	fani.prianti	$2y$12$4AIR6VYIqL8co28nKZLEj.6qyoMwgIC615nno4EFOloKDqdiJAbtG	3842	108707303	P	Purworejo	2010-08-25	3306046508100001	Islam	RT 1/RW 3 Kedungrejo Sokoagung Kec. Bagelen	Tego	Wanti
240	Mahmud Muhthoriq	3	\N	mahmud.muhthoriq	$2y$12$XLz8rPj4dvArVQ4NnL1Aeu5fGo1mokcLK.gPx6qq6.kYkhIzA.6iq	3846	102882515	L	Jakarta	2010-01-27	3172052701100001	Islam	RT 3/RW 1 Clapar Kidul Desa/Kel. Clapar Kec. Bagelen	Pujiyono	Kemiyem
243	Muhammad Ilham	3	\N	muhammad.ilham	$2y$12$tHsv.BIvt2FSMa9x/9V.S.QsHNk5srZUTGH46o77ua.7ZOvV8DBWi	3849	99126410	L	Purworejo	2009-12-03	3306060312090001	Islam	RT 3/RW 1 Kauman Desa/Kel. Ganggeng Kec. Purworejo	Narto	Winarti
246	Nadhif Ansor Riyadi	3	\N	nadhif.riyadi	$2y$12$5apnGQ3wKUehCb1BTRXqyeKO.Gukjr4LATE9Xl/jEst/A/U6QUkti	3852	94025217	L	Purworejo	2009-09-23	3306042309090001	Islam	RT 1/RW 2 Ngaglik Semagung Kec. Bagelen	Depi Wahyudi	Tunarti
249	Robbi Aqlil 'Ilma	3	\N	robbi.ilma	$2y$12$N7IuJ.vmMizPF09IDeieuuQhudV05NAmWO8fJvwL6QrHUncaJnrOW	3855	91310245	L	Purworejo	2009-12-21	3306162112090001	Islam	RT 3/RW 1 Pendemrejo Sendangsari Kec. Bener	Muh Fauzi	Siti Kholifah
251	Tegar Cahyono	3	\N	tegar.cahyono	$2y$12$G6UykbJ9jmkW3Th9DVzHUuxHlwVvZLRf.fiR2TWPDSE/ihl5Gq9ly	3857	105169984	L	Purworejo	2010-01-04	3306060401100001	Islam	RT 1/RW 1 Kedung Sari Kec. Purworejo	Teguh	Rumiyati
254	Virdo Arka Pratama	3	\N	virdo.pratama	$2y$12$ALDcGfGXxElnPHwxc01GheM57WhuDwXTzMYubT/24PzQmsP4HfTlG	3860	91579907	L	Purworejo	2009-06-22	3306132206090001	Islam	RT 1/RW 1 Desa/Kel. Kedung Sari Kec. Purworejo	Ari Fariyanto	Zait Hayati
300	Ika Nur Lutfiyah	14	\N	ika.lutfiyah	$2y$12$v0md.9ScCnln6b0yXkrbYOuPej35s2auRpgIlFtgoLCRq2F/URopm	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
330	Aulia Putri Rahmadhani	11	\N	aulia.rahmadhani	$2y$12$pj.ZNLikFfa4ccvzZrHl0OI4ahXQ3XqQSy80EN6Pdq/olSQYoC0KG	3618	94843623	P	Purworejo	2009-08-25	3306066508090002	Islam	RT 2/RW 5 Ngemplak Sido Mulyo Kec. Purworejo	M Sholahudin	Riyana
353	Riva Dwi Lany	11	\N	riva.lany	$2y$12$OlEGfAzRxWE39ccSmHSOROEPWhNgC0dcH0/nbYlVpOq7V6sNXTeXG	3622	96527125	P	Purworejo	2009-08-12	3306055208090001	Islam	RT 4/RW 3 Sawahan Somongari Kec. Kaligesing	Langgeng Pranoto	Riyanti
334	Estu Putri	11	\N	estu.putri	$2y$12$3QUnhKaq38CYxIOITuTkN.XVOvxLs492pZkpoDaOLhZwsQK1oT66m	3624	87080082	P	Purworejo	2008-10-15	3306045510080001	Islam	RT 1/RW 4 Karangrejo Kemanukan Kec. Bagelen	Legiman	Rini Astuti
339	Khannaila Diar Rosyda	11	\N	khannaila.rosyda	$2y$12$n2E41W49BWR5rur8EzeaIutQqBJXt3wbEA364h0rBylgxNbEUpro6	3629	96557543	P	Purworejo	2009-02-16	3306065602090001	Islam	RT 4/RW 2 Kedungsari Desa/Kel. Kedung Sari Kec. Purworejo	Ari Setiadi	Dwi Pujiastuti
341	Meisya Rochayati	11	\N	meisya.rochayati	$2y$12$sEdL.9DbAUKSwtAPg.Xcb.bU5Gl3dfFgwetRm3uXvaIklDFSVsYWW	3631	75008549	P	Purworejo	2007-05-18	3306065805070001	Islam	RT 1/RW 3 Tambakrejo TAMBAKREJO Kec. Purworejo	Karno Mulyo	Rusminah
345	Nova Susiyana	11	\N	nova.susiyana	$2y$12$EpNWcHlr0A89lWck1Pz7HuU1nTK9njtByD.dIQx7TWilzWT.wkqsu	3635	84712788	P	Purworejo	2008-11-26	3306066611080002	Islam	RT 5/RW 2 Majan Wonoroto Kec. Purworejo	Rudi Darmawan	Venti Fatimah
349	Putri Aprilia Nur Muflichah	11	\N	putri.muflichah	$2y$12$Tf6IO/rswuZfeUeTteN7zuHn5DA9x.14UM363O.bnut12y2/xOEHK	3639	95877334	P	Purworejo	2009-04-09	3306064904090001	Islam	RT 2/RW 1  Desa/Kel. Tambakrejo Kec. Purworejo	Joko Santoso	Siti Chotijah
352	Rita Khorivah	11	\N	rita.khorivah	$2y$12$92DMis1tlP3LvzP7Lr/ELO6eT9.1Qha9RGp/QxtM.vmSTBzPSRaUq	3642	91121118	P	Purworejo	2009-11-06	3306044611090001	Islam	RT 4/RW 1 Kaliagung Sokoagung Kec. Bagelen	Amat Wahid	Wagiyem
357	Syifa Nur Aini	11	\N	syifa.aini	$2y$12$e7Zrfl2vZGsvmPHh5U4SG.fNbMgNx28u6lwedGkWZVJkH8zg/DVxq	3646	81238542	P	Purworejo	2008-07-11	3306155107080001	Islam	RT 1/RW 1 Glagah Ombo Desa/Kel. Banyuasin Separe Kec. Loano	Muhamad Ngimron Nawawi	Siti Asroriyah
360	Yunita Tri Herawati	11	\N	yunita.herawati	$2y$12$NYUTKuLIletvUt.vmmYaXupU7vOCK81ugUkcGGJgdXsd7AxvWl4me	3649	89117103	P	Purworejo	2008-06-07	3306044706080001	Islam	RT 1/RW 1 Krajan Lor Piji Kec. Bagelen	Suyono	Sumartini
272	Fatkhur Akbar Pangestu	13	\N	fatkhur.pangestu	$2y$12$D56x0nPYkyuXi2P0WvKKQOhGisXciK6gufVPyAbd6VX3k1z5cxPNK	3701	83055482	L	Purworejo	2008-10-11	3306041110080001	Islam	RT 1/RW 4 Gumuk Piji Kec. Bagelen	Wiyono	Eni
275	Helena Happy Lestari	13	\N	helena.lestari	$2y$12$ePVaFdmJ/tH76w1nK.DHN.A7RM3noZAVmQQ/IIiugcZ3CnE3Xva.6	3704	91708213	P	Purworejo	2009-06-27	3306056706090001	Islam	RT 1/RW 1 Kedungrejo Desa/Kel. Kaliharjo Kec. Kaligesing	Agus Parmanto	Yuliani
279	Lu'Luul Maknunah	13	\N	luluul.maknunah	$2y$12$1CAHLchPh7Y9Iu7rBmZ01uiFaLDGy41DYVH3fYZQDV5jeO/WOe5oy	3708	78656996	P	Purworejo	2007-08-20	3306066008070002	Islam	RT 3/RW 8 Krajan Baledono Kec. Purworejo	Heni Risanto	Siti Amanah
282	Pratista Conita Arwen	13	\N	pratista.arwen	$2y$12$2HudjyY6zPqW24ubzzZ46O4XN7VpPtuDJ6pKTFUb.hG7oX0Mh72ki	3711	92874855	P	Purworejo	2009-04-29	3306046904090001	Islam	RT 2/RW 3 Karang Sari Kemanukan Kec. Bagelen	Wakidi	Nunuk Purwaningsih
285	Rania Dwi Puspita	13	\N	rania.puspita	$2y$12$0JoipYzOiHkjzUHmkR87fuy7n8PbnfIEAs1vuYycs42Q3OGyLLDVm	3714	81709044	P	Purworejo	2008-11-09	3306064911080002	Islam	RT 1/RW 4 Cocolan Pacekelan Kec. Purworejo	Harno	Partini
288	Shifa Nuril Fadhilah	13	\N	shifa.fadhilah	$2y$12$ug8cS//PbLKqvIZpL.v1QO7M8Gt3anrO8vWfSjLYhK.2U1WirjOMW	3717	98750295	P	Purworejo	2009-03-11	3306165103090002	Islam	RT 1/RW 2 Donorati Donorati Kec. Purworejo	Sulaeman	Kustiyani
292	Vina Nur Yanti	13	\N	vina.yanti	$2y$12$t78SHZ6Lo8gBB8Z8MqV5GOFIKdyyDfLp6EIiueVcDJ26hfTPgOHZm	3721	97081071	P	Purworejo	2009-02-01	3306044102090001	Budha	RT 2/RW 2 Sekangun Sokoagung Kec. Bagelen	Tusirin	Windarti
295	Deviana Nur Latifah	14	\N	deviana.latifah	$2y$12$mEO.XhF24DcOIeKzhJXoWeb5ybYEVWY1RmvgB8O3qnObEMmVkHtr2	3724	84660949	P	Purworejo	2008-04-04	3306044404080002	Islam	RT 2/RW 2 Sikuning Hargorojo Kec. Bagelen	Tumino	Turiyah
297	Efrila Fika Putri	14	\N	efrila.putri	$2y$12$GQf9Koi/4fGG8CjCUSpp7enYeW6bu/19hvb/PLVGBktJaUxNg1tGS	3726	99048427	P	Purworejo	2009-04-27	3306046704090001	Islam	RT 1/RW 3 Kedungrejo Sokoagung Kec. Bagelen	Pujiono	Suminah
302	Julia Uswatun Khasanah	14	\N	julia.khasanah	$2y$12$KRpCfYkIoTsGhnbXVNuzXO8KySLVJAoveOCeBlrqEZrH9x9kkwKG.	3731	94945212	P	Purworejo	2009-07-14	3306045407090001	Islam	RT 7/RW 1 Keposong Desa/Kel. Krendetan Kec. Bagelen	Risqon	Misiyem
305	Linda Khairunisa	14	\N	linda.khairunisa	$2y$12$LrBjI66cWczwlVIU/cXaz.37nPNSeDWXDGoI2xQeyEhw23vh1ZRcO	3734	99931848	P	Purworejo	2009-07-29	3306056907090001	Islam	RT 10/RW 2 Krajan Jatirejo Kec. Kaligesing	Subagiyo	Poniwati
309	Nabila Nurul Maulida	14	\N	nabila.maulida	$2y$12$IA.NeYPqYBQeN04VL4OWNe05xvhDOAHAnx0cSAg9dn4P.jkAVjFqS	3738	99900800	P	Purworejo	2009-03-16	3318215603090002	Islam	RT 5/RW 1 Katerban Donorejo Kec. Kaligesing	Makmur	Sutrismi
311	Nevi Agoestina	14	\N	nevi.agoestina	$2y$12$MoTce3upYvXMNO/xYtrqNeQMOhCTGH8eZd5SO60j1vXIMsePneF3m	3740	95699463	P	Purworejo	2009-08-17	3306065708090002	Islam	RT 2/RW 2 Ganggeng Ganggeng Kec. Purworejo	Novianto	Ernawati
315	Putri Nur Mudma'Inah	14	\N	putri.mudmainah	$2y$12$pJ9Ijyr2xos8FS6jF3vvyuDcfXrNH77SCq7Uacp79u7KI5Zw2SaVi	3744	3084664602	P	Purworejo	2008-03-19	3306065903080003	Islam	RT 1/RW 3 Sejati Desa/Kel. Brenggong Kec. Purworejo	Agus Sumaryadi	Kasanah
318	Rifka Rachel Ulima	14	\N	rifka.ulima	$2y$12$YthqI3AF7QJ26nYE6RvgjeMfpKbJhnACnwCc9c8w8y0K35DLkSaYa	3747	97819590	P	Purworejo	2009-04-10	3306065004090004	Islam	RT 4/RW 1  WONOTULUS Kec. Purworejo	Nurhuda	Ririn Wahyuni
321	Syaila Nayla Alifah	14	\N	syaila.alifah	$2y$12$zQ9XGL5.4S05jnacaTryl.NS4dYV.zGpXwZ1iWgM0zKzmSF4L0ND.	3751	86031827	P	Purworejo	2008-12-22	3306046212080001	Islam	RT 3/RW 2 Krajan Wetan Kemanukan Kec. Bagelen	Kasmino	Jumini
323	Tyrza Anastasya	14	\N	tyrza.anastasya	$2y$12$gNfzD3wQGOuG5.7VFB23.ODsm47878IclLsn5mTAiAtc.wL4S0sYy	3752	92942259	P	Purworejo	2010-01-04	3306064401100002	Islam	RT /RW   Sido Mulyo Kec. Purworejo		Khomsatun
409	Galang Yudho Wicaksono	8	\N	galang.wicaksono	$2y$12$SdyMv6qwz63N8YpA7Zh.L.vqG.srsV1QaEu6pFw/j354QiwyEF1zu	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
399	Anang Kholilur Rohman	8	\N	anang.rohman	$2y$12$B2zQAOy1CDVb/YRQM19VNOvsNbmBDY2eKChJFNecly3PZQbGr6oFi	3518	87491463	L	Purworejo	2008-12-06	3306120612080001	Islam	RT 1/RW 1 Santren Desa/Kel. Loning Kec. Kemiri	Sohib Bahri Anwar	Yulianti Farida
403	Epi Ndaru Candra Kartika	8	\N	epi.kartika	$2y$12$MHrOtFuEHs3REKHpUpj5LOzoNlot1WCdaPojwp//DanoklYqNSeS6	3522	93270848	P	Purworejo	2009-04-30	3306147004090001	Islam	RT 2/RW 4 Kemantren Kidul Gebang Kec. Gebang	Wahyu Dwi Astuti	Wahyu Dwi Astuti
406	Farhan Alif Prasetyo	8	\N	farhan.prasetyo	$2y$12$jfbvclMis1YQPxui77Td.uG1uqGd3BXS5KotuNDgjvOmr.rlDQwTu	3525	95366217	L	Purworejo	2009-05-03	3306060305090002	Islam	RT 3/RW 2 Paculan Ganggeng Kec. Purworejo	Riyanto	Mita Andriyani
411	Hafiz Al Qorni	8	\N	hafiz.qorni	$2y$12$U.LyBugAZRNQpu0gbb12bu6W61dSBy5AgQUo/Rw1mKakLxMy5gRBq	3530	88309506	L	Purworejo	2008-09-23	3306062309080004	Islam	RT 2/RW 5  Desa/Kel. Tambakrejo Kec. Purworejo	Hari Murtiadi	Budiyanti
414	Mistades Aryano	8	\N	mistades.aryano	$2y$12$TTnMeO1LabRCLE.A7zPLPeoUOslrTPM7MYek/doZNNPG1ZzBYC5CO	3533	89458954	L	Purworejo	2008-07-31	3306043107080002	Islam	RT 1/RW 4 Karang Rejo Kemanukan Kec. Bagelen	Sukaryadi	Tri Utari
417	Muhammad Rizki Yanto	8	\N	muhammad.yanto	$2y$12$a3dSXC9WJjXfGqSHtTsKi.dLZmT5BqZNJTrPERi5MZP3HFr1cunWW	3536	84779292	L	Purworejo	2008-06-18	3306061806080005	Islam	RT 5/RW 9 Baledono Baledono Kec. Purworejo	Jemu Mulyono	Nur Faizah
436	Arsa Radhitiya	9	\N	arsa.radhitiya	$2y$12$3uO9GjCb8mb3dqP1KojgFu.bk4EcRmwSxX3GQwnuqOfL5lSaHs.SC	3555	82989839	L	Purworejo	2008-07-28	3306062807080001	Islam	RT 2/RW 4 Mranti Mranti Kec. Purworejo	Erwanto	Darti
438	Damar Wisongko	9	\N	damar.wisongko	$2y$12$0972cxqTy29slXGvsFIUl.e3RmzHAEhewSHhYvMjRTwog.toUn0WC	3557	71287746	L	Purworejo	2007-12-19	3306051912070001	Islam	RT 1/RW 3 Sawahan Somongari Kec. Kaligesing	Sarno	Napsiyah
440	Eca Kirana Putri	9	\N	eca.putri	$2y$12$ljWYilECBJEZV0S4mrTZhOZhtTOrBdm0FOMACJZKtPjmgBPsgsGHW	3559	99217203	P	Purworejo	2009-02-26	3306036602090001	Islam	RT 1/RW 3 Dusun Watu Lembu Desa/Kel. Banjarsari Kec. Purwodadi	Suyanto	Andriyanti
442	Galang Khoirul Ichsan	9	\N	galang.ichsan	$2y$12$M9ubvS/s8fm.DZ4ON10tIOHfbdGEIpf9tsEzGxvJGPX0kMpKs1xPm	3561	95320893	L	Purworejo	2009-04-03	3306060304090004	Islam	RT 1/RW 6 Sidomulyo Sido Mulyo Kec. Purworejo	Sujatmiko Darmawan	Suyatmi
443	Galang Satria Utama	9	\N	galang.utama	$2y$12$DrezbRhvogNe7uyAcPiikO1D6gG/bRoE8ZNduOmYyyaehbZ323mAC	3562	88815109	L	Purworejo	2008-03-13	3306061303080001	Islam	RT 2/RW 1 Krajan Cangkrep Lor Kec. Purworejo	Nur Hakim	Endang Widiastuti
445	Ikhsan Pratama	9	\N	ikhsan.pratama	$2y$12$8jlP7TQ4luETYaylB.stkOuQ9pCDEVQiMjv5q1lyVqag8yfjKY6eG	3564	99886629	L	Purworejo	2009-06-04	3306060406090001	Islam	RT 2/RW 2 Karang Tengah Paduroso Kec. Purworejo	Mochamat Samsi	Agustina
446	Inggo Manna Azaro	9	\N	inggo.azaro	$2y$12$ac65NoURdo8h7ee5wE7cIOq8M.lLxLjhAIpH78px5DEmyd3hkpNdu	3565	3094660409	L	Kebumen	2009-04-05	3306120504090004	Islam	RT 2/RW 3 Kliwonan Desa/Kel. Girimulyo Kec. Kemiri	Fitri Nurcahyanto	Novalia Andini Saputri
448	Mario Cahyo Anggoro	9	\N	mario.anggoro	$2y$12$fS8BlnhiGrL/NhLcrZZu4udJQ9tNsyhCnbVs.k/0OFUmiSQuB5GQe	3567	87115976	L	Majalengka	2008-03-14	3210241403080001	Islam	RT 1/RW 4  Lugosobo Kec. Gebang	Bintoro	Elis Juaenah
450	Muhamad Aldan Hanif	9	\N	muhamad.hanif	$2y$12$3w9nzsZ1lXPE0/lJp30m9ufviznEFkT27HidcgutZjKaBzGu5n9wm	3569	94802407	L	Purworejo	2009-04-27	3306062704090002	Islam	RT 1/RW 1 Sidomulyo Desa/Kel. Sido Mulyo Kec. Purworejo	Muhsi Anwar	Musarofah
451	Muhammad Anwar	9	\N	muhammad.anwar	$2y$12$3xCcIMvs3j70unESI0qhWOw8i3ZVr4wigWQ6M6qTekX342O6oRYYG	3570	84940138	L	Purworejo	2008-03-27	3306072703080001	Islam	RT 3/RW 3 Popongan Kidul Popongan Kec. Banyu Urip	Harris Setiawan	Supratmi
363	Atifa Kamilah Dwi Aisyah	12	\N	atifa.aisyah	$2y$12$JCErcfwOpQntblDvf3ht.eb4rtZQtw132ShkA1i0Dt7z2OrQJ3Ufq	3652	89753139	P	Purworejo	2008-11-13	3306165311080003	Islam	RT 2/RW 3 Kaliboto Wetan Kaliboto Kec. Bener	Wahyu Eko Saputro	Titik Suharyanti
367	Aziza Rahma Maulida	12	\N	aziza.maulida	$2y$12$BIhex4BSLn1jL.fbzSfBoeKEzu2zp93Wos4VF3j4v9MQvWHND8jHS	3656	98673339	P	Purworejo	2009-03-16	3306125603090002	Islam	RT 2/RW 1  Girijoyo Kec. Kemiri	Khabib Muh Asnawi	Ropingah
370	Ferlita Eka Cahyanti	12	\N	ferlita.cahyanti	$2y$12$RZw3sqzYpM0UBh8bBIlm2eE2np/1ScKzv7PrU6gzUX0Fm5J5/OLDG	3659	93437097	P	Kediri	2009-06-30	3506137006090001	Islam	RT 1/RW 3 Sucen Semawung Kec. Purworejo	Eko Pujianto	Deti Triyanti
372	Fika Cahyaningrum	12	\N	fika.cahyaningrum	$2y$12$1x1VQma2Ph1u2lyaXfeM9.nf05ZyOXUqNcEQSSZKG3Rv.RQinu5eu	3661	91103360	P	Purworejo	2009-03-05	3306044503090001	Islam	RT 1/RW 2 Sijo SEMONO Kec. Bagelen	Harto  Kabari	Tumirah
375	Lina Nur Astuti	12	\N	lina.astuti	$2y$12$MajOgrM.pmbEsgjA.UugWevoOG9UEBQCEmaj09nVmHIuH7nhT5sW6	3664	94500769	P	Purworejo	2009-02-21	3306066102090001	Islam	RT 2/RW 2 Jogoresan Ganggeng Kec. Purworejo	Sukoco	Dwi Wiji Astuti
378	Otrit Novariska	12	\N	otrit.novariska	$2y$12$ZN0AqQhOZB1Ahh2adYce5Oin5/UCMpERDa4OLOCPJ4Sse8sO1FeVi	3668	97321782	P	Purworejo	2009-12-12	3306035212090001	Islam	RT 1/RW 2 Dusun Kliwonan Sukomanah Kec. Purwodadi	Sutirto	Surati
381	Rika Rahmadani	12	\N	rika.rahmadani	$2y$12$T6bCeTP8ddhnJg8sQrkuuO0/x8Z5kRf0bKqUNYPNhbeTt8sAisoS.	3671	92927129	P	Purworejo	2009-08-22	3306146208090002	Islam	RT 4/RW 5 Tengahan Seren Kec. Gebang	Sukemi	Rukiyah
385	Salma Nabilla Azzahra	12	\N	salma.azzahra	$2y$12$UJZ21cGfRWf9kKUxdjhAuew.yX2p5RDdet.PguH0TllZNPxCtsJfq	3675	95280053	P	Purworejo	2009-02-17	3306055702090001	Islam	RT 2/RW 2 Krajan Tlogobulu Kec. Kaligesing	Sandi Yusuf	Tri Budi Rahayu
388	Shazia Artaningrum	12	\N	shazia.artaningrum	$2y$12$b.Fde7bkEN1DQZgYTgmgS.SsEGtlt5n5WQgpS9ud22X1WfPwEYNIy	3678	91939866	P	Semarang	2009-01-25	3374116501090001	Islam	RT 2/RW 1 Tambakrejo Desa/Kel. Tambakrejo Kec. Purworejo	Agung Riswanto	Tri Atmojowati
391	Untari Tias Asih Nugraheni	12	\N	untari.nugraheni	$2y$12$cTQWjCG5O5WhDODaX9ovzu9UFgaKQkB1RAtaR0zevGV5aU3VN0zDW	3681	96489757	P	Purworejo	2009-03-21	3306046103090001	Islam	RT 5/RW 1 Dremosari I Durensari Kec. Bagelen	Untung	Jumarsih
394	Yuda Wijayanti	12	\N	yuda.wijayanti	$2y$12$INQv21fzPudMUDPgwhpqd.nPJ3hp2ANeE9uT02d/DLv6qHi55ttz.	3684	95146249	P	Purworejo	2009-09-28	3306046809090001	Islam	RT 3/RW 2 Sijo Semono Kec. Bagelen	Orin	Sulastri
498	Ardiansya Alifya Septya Nugroho	19	\N	ardiansya.nugroho	$2y$12$vPvtOwSCUqbv1O4daxNJX.X9oTkHaswANGDBOdIgXDHIyRIShA1s.	3447	146576623	L	Purworejo	2007-09-02	3306060209070001	Islam	RT 2/RW 1 Sidomulyo Sidomulyo Kec. Purworejo	Slamet Sugiharto	Rubaniyah
501	Asmaa Nur Kamilah	19	\N	asmaa.kamilah	$2y$12$jxTFy.KE1VMoQ7M6iUcN3u87uLubHzd6.C0Ox7WQcxOlizXFmR4iu	3450	89652317	P	Purworejo	2008-03-10	3306065003080002	Islam	RT 7/RW 14  Desa/Kel. Sido Mulyo Kec. Cakung	Subur Rochman	Winarsih
505	Deny Saputra	19	\N	deny.saputra	$2y$12$KpKQK5Xd/ELz3UexVWFRs.tjC.pQ/lR4oBLbCkTqmBgSI.YcMWVqm	3454	78098809	L	Purworejo	2007-05-19	3306041905070001	Islam	RT 4/RW 3 Ketitan Sokoagung Kec. Bagelen	Sumiran	Yatiyas
508	Erlin Ramadhani	19	\N	erlin.ramadhani	$2y$12$gY6dlb/E7WCQsZ4Ki895cekmEcJ/RqnQ2s5csMYrClErgthI1GAJS	3457	78040293	P	Purworejo	2007-09-27	3306066709070002	Islam	RT 5/RW 9 Baledono Desa/Kel. Baledono Kec. Purworejo	Edi Kristian	Nurul Fatimah
511	Indah Puspitasari	19	\N	indah.puspitasari	$2y$12$b5xT8uZ93Wz0U2T4aB902encMTgI/BheZp8n/LR9CAkNX8hXV5FtK	3460	75230745	P	Purworejo	2007-04-01	3306034104070001	Islam	RT 1/RW 3 Purwogondo Desa/Kel. Purwosari Kec. Purwodadi	L	Siti Nurjanah
513	Intan Nur Azizah	19	\N	intan.azizah	$2y$12$oOjMFWceuloaZrEgi7QRluGCdgylHr9MoGpEUkjvekxU2QWsNtOJa	3462	76019650	P	Purworejo	2007-12-14	3306065412070001	Islam	RT 1/RW 1 Sumberjo Desa/Kel. Ganggeng Kec. Purworejo	Busono	Siti Rifani
516	Lucky Handayani	19	\N	lucky.handayani	$2y$12$1Z6BHmVAGN9R.imAOD3gaubMjbr5cgZEsq/z6iVlZVMsp/m4/elTi	3465	85126164	P	Purworejo	2008-12-18	3306065812080001	Islam	RT 1/RW 2 Krajan Kulon Pacekelan Kec. Purworejo	Abdul Rahman	Metri Yeni
522	Nova Sandria Zahra Nadhifa	19	\N	nova.nadhifa	$2y$12$FIxcxHj7f7jtW.jjDFAomeiCqtykA5ZHJ1VGQZKFZN3M/TyLlfyOe	3471	74100938	P	Purworejo	2007-11-16	3306045611070002	Islam	RT 1/RW 2 Sijo Desa/Kel. Semono Kec. Bagelen	Endriyanto	Nuri Lestari
525	Syafrida Yuliana	19	\N	syafrida.yuliana	$2y$12$kvRWWvyYXTcM6AUR7ErqDux5GNyxKVIP14WXbC6rCPJcK8D2cMPLK	3474	85727544	P	Purworejo	2008-07-16	3306065607080003	Islam	RT 3/RW 2 Cangkrep Lor Desa/Kel. Cangkrep Lor Kec. Purworejo	Teguh Suprihatin	Dwi Setiowati
590	Riska Anggita Salsabela	17	\N	riska.salsabela	$2y$12$/NUUwU5zjCrZfNbNTAuShuwTGoY3VW4AvIcsWSP5wi09izhyTzap6	3396	87475391	P	Purworejo	2008-03-28	3306056803080002	Islam	RT 2/RW 2 Jogowangsan Tlogorejo Kec. Tanon	Sutomo	Supriyati
593	Safhira Larasati	17	\N	safhira.larasati	$2y$12$QKnIaR09NojdRXlQVIg89O2GbV7ACI.TmPooANjpmqaTrjIO/AC7G	3399	84135009	P	Tangerang	2008-10-26	3306076610080002	Islam	RT 2/RW 1  Desa Kebonsari Kec. Purwodadi	Darusman	Ike Dwi Astutik
596	Sheila Wahyu Utami	17	\N	sheila.utami	$2y$12$3MumcfbQApfdZqnyZE0uK.pdc97quLGUZwU4OsVcSK9.3q5MllHe.	3402	79783603	P	Purworejo	2007-11-17	3306055711070001	Islam	RT 3/RW 4 Kedungrante Desa/Kel. Kaligono Kec. Kaligesing	Budiman	Wagini
599	Tiyas Maharani	17	\N	tiyas.maharani	$2y$12$nRQ9Kdw3E7krZPNMYcXJbO8pvxlDL7fmYPtSOYBON2IDITYQl0xzG	3405	87341141	P	Purworejo	2008-05-14	3306065405080002	Islam	RT 1/RW 7 Kenyaen Ii Semawung Kec. Purworejo	Sugiyanto	Wijayanti
603	Alisa Tri Akhiri	18	\N	alisa.akhiri	$2y$12$4vTx6PYR70GD6fqcfU3RkOhodQ6jzqvGuFdtXUP0H/gO5bYQ/Uu2y	3409	86857013	P	Purworejo	2008-07-10	3306065007080001	Islam	RT 1/RW 7 Tambakrejo Desa/Kel. Tambakrejo Kec. Purworejo	Tugiran	Ponimah
453	Narindra Budi Pratama	9	\N	narindra.pratama	$2y$12$/KF3.Z7MocbHD7OlFYkzje1/1KWpWXurhSdrSZaw73GJpJVBo4YWi	3572	96879656	L	Purworejo	2009-06-23	3306062306090001	Islam	RT 2/RW 7 Semawung Semawung Kec. Purworejo	Bambang Budi Santoso	Siti Latifah
456	Rayhan Awalian Nurohman	9	\N	rayhan.nurohman	$2y$12$/XNrOkRgvopUb9e5wzrFme5VPx4YNemxig/8Wk9BRjTWvN21PKPUe	3575	97338818	L	Purworejo	2009-02-07	3306040702090002	Islam	RT 4/RW 1 Piji Piji Kec. Bagelen	Sukiman	Romiyati
459	Saiful Abyan	9	\N	saiful.abyan	$2y$12$jDDbzRsy9ptdTgsr56yco.o1lS4gieI8sK6NgYde6YeLUNLrQoFhm	3578	3087172733	L	Purworejo	2008-04-23	3306062304080002	Islam	RT 2/RW 12 Tambakrejo Desa/Kel. Tambakrejo Kec. Purworejo	Fathul Wahab	Lilik Kristiyani
463	Achmad Nuhalmustawi	10	\N	achmad.nuhalmustawi	$2y$12$8MJSL6y8YOVo6s3E6ryEW.VzPoj.dnddPUwkm33fXc4.SyDzIPjcC	3582	91737997	L	Purworejo	2009-09-28	3306062809090001	Islam	RT 1/RW 7 Semawung Semawung Kec. Purworejo	Murwani Karso	Nur Khayatun
466	Alifia Nadiatun	10	\N	alifia.nadiatun	$2y$12$.5NVtkBo9oxjE2IyRTe5AO6ZwL2LUUTjVQzhxRd0zMElfdvGlA4pa	3585	99878058	P	Purworejo	2009-07-13	3306065307090001	Islam	RT 1/RW 1 Sidomulyo Desa/Kel. Sido Mulyo Kec. Purworejo	Eko Budiyanto	Mufidatun
469	Arya Budi Pratama	10	\N	arya.pratama	$2y$12$fzJNCwg8Ynj9cMUDeTVdhuO1zYssXHcApbZKPnS4jdEQMxJD8GbJW	3588	81101302	L	Purworejo	2008-11-01	3306050111080001	Islam	RT 0/RW 0 - - Kec. Temon		Prihatin Puji Rahayu
471	Dhimas Osama	10	\N	dhimas.osama	$2y$12$AYBAhewHinywCulHcJHi7.68t8x1jPeOmfJRq1JErU8e3/X9QVPYa	3590	92149985	L	Purworejo	2009-02-19	3306031902090001	Islam	RT 3/RW 1  JENARLOR Kec. Purwodadi	Sahdan	Tumini
476	Ibnu Rizky Shobari	10	\N	ibnu.shobari	$2y$12$pISZUu5X3IyKsYELBMoQteTY/GpLStpIo6Gp.mjPS9KI7lLaLtrS6	3595	99035843	L	Purworejo	2009-02-23	3306052302090001	Islam	RT 13/RW 3 Sigayang Jatirejo Kec. Kaligesing	Sri Robiantoro	Harsini
477	Iqmal Kurnia Riski	10	\N	iqmal.riski	$2y$12$Uw//xb1Qm1h2VaME9yuBHegGO7VlkGp1RKYY/SwluRARXgou18SYy	3596	72821669	L	Purworejo	2010-01-28	3306042801100002	Islam	RT 1/RW 3 Bugel Desa/Kel. Bugel Kec. Bagelen	Darsono	Sri Sudiharti
481	Muhammad Alwy Ahsan Fadlullah	10	\N	muhammad.fadlullah	$2y$12$1bWaQBjNkSFoWuK28eIkGeaUQ3pk/mOSdUkp9zyErYtSkGUuR6.e6	3600	83419412	L	Bandung	2008-08-02	3277020208080004	Islam	RT 3/RW 1 Caok Desa/Kel. Karangrejo Kec. Loano	Mukhsin	Chairusiyam
484	Nasichatul Faricha	10	\N	nasichatul.faricha	$2y$12$UW.DqwbVWtv178Sdk3/nb.8G0YCZbpmuwzcW4u54IxyCkCsOL1.mK	3603	92568011	P	Purworejo	2009-03-15	3306155503090001	Islam	RT 2/RW 2 Pejaten Tridadi Kec. Loano	Usul	Suparti
487	Rizki Ardiansyah	10	\N	rizki.ardiansyah	$2y$12$C5H0QybQ/1c.vTsG4XC5pen7j0aOL.lFu/7DqFZZpx8Eih3KABdpi	3607	92704089	L	Purworejo	2009-03-18	3306041803090001	Islam	RT 3/RW 3  Piji Kec. Bagelen	Suyatno	Ernawati
490	Sofyan Nur Fadhilah	10	\N	sofyan.fadhilah	$2y$12$8JUBz4fuxqDsPIXLipRSL.q8/xZy/9HJXil0prhHoA45s9L3DA1nO	3610	87595653	L	Purworejo	2008-12-18	3306061812080001	Islam	RT 2/RW 3 Tawangrejo Keseneng Kec. Purworejo	Darmadi	Sopiyatun
493	Wildan Hadi Nugraha	10	\N	wildan.nugraha	$2y$12$Rdx9XQNkjPYWMysDUfww0eIw4ZSYlTHhSrC8mJzpJ45fLiDuC669y	3613	95954799	L	Purworejo	2009-03-29	3306062903090003	Islam	RT 0/RW 0  Sido Mulyo Kec. Purworejo	Siswo Hadi	Erni Noviastuti
531	Anggia Widaryanti	20	\N	anggia.widaryanti	$2y$12$mZwa4CUosaSuP2ZZAAiUT.f2Dg6LKpMhSy1DihvDyCl26XFpzu2sC	3480	84019956	P	Purworejo	2008-08-20	3306046008080001	Islam	RT 1/RW 2 Sijo Semono Kec. Bagelen	Kaswandi	Budiyanti
534	Arvany Intan Puji Pangestuty	20	\N	arvany.pangestuty	$2y$12$IMBSh132ZmYKbA2pnJjBQelHsfhy1KwG8P9K2N9pY0KuyhT/rFiRa	3483	77153591	P	Purworejo	2007-03-06	3306044603070001	Islam	RT 2/RW 1 Keposong Desa/Kel. Kalirejo Kec. Bagelen	Apid	Waida Endariasih
538	Bunga Zahra Octaviani	20	\N	bunga.octaviani	$2y$12$jPMzPqToHKAUyU.1S5U41uJEfKx0H0V16BUOirNG7ln66.wkcs1da	3487	79747594	P	Purworejo	2007-10-24	3306046410070002	Islam	RT 5/RW 2 Kuwojo Dadirejo Kec. Bagelen	Sigit Gunawan	Erniawati
541	Dewi Nawangsari	20	\N	dewi.nawangsari	$2y$12$QyNQBgQkrMv27ozchTO0s.lqJq.IAJGLv4vsSdHOSTmbvOWiChEwu	3490	87121476	P	Purworejo	2008-02-18	3306075802080001	Islam	RT 1/RW 2 Borotawang Boro Wetan Kec. Banyu Urip	Subrig Abadi	Ngayem
544	Eka Safri Khusnul Aziza	20	\N	eka.aziza	$2y$12$gJ1Ez3dHH2vUCRBZc6KY4O18ceTeETncvqEahMSv7i5indT/qkPlG	3493	83428326	P	Purworejo	2008-02-22	3306056202080001	Islam	RT 3/RW 7 Wonorejo Desa/Kel. Kaligono Kec. Kaligesing	Jemino	Watiyah
548	Fika Aisyah	20	\N	fika.aisyah	$2y$12$AzTI6W1jGmEQzVBwfUTNAOotOIqmiPYrJ1i0JDir4KOH1wSiGcdey	3497	81324527	P	Purworejo	2008-06-26	3306036606080001	Islam	RT 2/RW 1 Dhudhuan Desa/Kel. Sumbersari Kec. Purwodadi	Bejo Setiyadi	Parijah
551	Jeny Nurdiana	20	\N	jeny.nurdiana	$2y$12$DrZIUo7ad2RqLHlf2UOiiu27oYUH1wY6SpHtAdfQUthoJ331DU8t2	3500	86183981	P	Tangerang	2008-06-16	3671025606080004	Islam	RT 2/RW 4 Semagung Wetan Semagung Kec. Bagelen	Suwarjan	Parnida
554	Karisma Janika Putri	20	\N	karisma.putri	$2y$12$X5kdcmswON3KoNAzR6LpqOnK/KAs97Oh/8qF2kRqOnSBJ1QSdiZY.	3503	82813882	P	Jakarta	2008-06-17	3173075706081001	Islam	RT 4/RW 3 Projayan Cangkrep Kidul Kec. Purworejo	Budiman	Susi Ambarsari
557	Norma Permatasari	20	\N	norma.permatasari	$2y$12$B2hhxIpDZAw73OySdL4s0eMfxtHzytjTFrQO6fpu8C3K0JCgiOvB2	3506	82907257	P	Kebumen	2008-05-08	3306034805080001	Islam	RT 8/RW 3  Desa/Kel. Bubutan Kec. Purwodadi	Sukino	Sri Masamah
561	Saring Gunawan	20	\N	saring.gunawan	$2y$12$sG21tsk7HgnH6bkFgGuQcOt85ZxNdzSi.VQ7dAKE8pPgHMcxju.Ai	3510	75716146	L	Purworejo	2007-08-19	3306051908070001	Islam	RT 16/RW 3 Sigayang Desa/Kel. Jatirejo Kec. Kaligesing	Sarimin	Sukarmi
564	Siti Fatimah Bunga Putri	20	\N	siti.putri	$2y$12$vOll/sl6dAN9rjyEMCxlwukHZ9bEIpyey6ZyRifYjyrSE8kD1cyjO	3513	82721635	P	Purworejo	2008-06-16	3306065606080007	Islam	RT 3/RW 7 Jatisalam Semawung Kec. Purworejo	Urip Sarwono	Siti Munawaroh
567	Adellia Putri Utami	17	\N	adellia.utami	$2y$12$zFcirjm2u9W2aX.fM9aSlerMohF4DHvTWiRoaIsZjhp2k.y4beCq6	3372	76734776	P	Purworejo	2007-09-11	3306055109070001	Islam	RT 2/RW 4 Gogoluas Tlogoguwo Kec. Kaligesing	Arsono	Suryanti
570	Ata Farhansyah	17	\N	ata.farhansyah	$2y$12$4LuZhq5T97pisFdy3imDHORQ.5TaAPKpIZZjxoRny8ESN.7ZK1UgO	3375	82387884	L	Purworejo	2008-03-03	3306060303080001	Islam	RT 5/RW 2 Kedungsari Kedung Sari Kec. Purworejo	Riwanto	Suparminah
574	Dewi Agus Trilestari	17	\N	dewi.trilestari	$2y$12$SDV8xVhGxk4Jv1cd0rHC.eJoM1.PIn71IbGuHP9AEOdc4qSBHjD36	3379	84576125	P	Purworejo	2008-08-06	3306044608080001	Islam	RT 8/RW 3 Kedungrejo Sokoagung Kec. Bagelen	Mujino	Sarmi
575	Dina Adi Fatma	17	\N	dina.fatma	$2y$12$mGq2bW5SluBvXvO/zGkTZOyljdROKPTt74fLawxiC2j0F.EaMQkvW	3380	82043409	P	Purworejo	2008-03-24	3306066403080003	Islam	RT 1/RW 1  BALEDONO Kec. Purworejo	Poniman	Erni Susanti
578	Fitri Febriyanti	17	\N	fitri.febriyanti	$2y$12$4GpjO5v6KCJj6igJ1W1qjONVXdjZf79KzTJxUHmNZyYeZW0rAaGQa	3384	86463334	P	Purworejo	2008-02-23	3306066302080003	Islam	RT 1/RW 3 Ndukuh Ngabean Kedung Sari Kec. Purworejo	Tuwatman	Sumirah
582	Lia Puspita Sari	17	\N	lia.sari	$2y$12$Hjpg2VpJHfwhIU7/sQ47.Opt6PzEYulEW7My.2KGowHwBBqBvI/nW	3388	87930237	P	Purworejo	2008-03-12	3306065203080001	Islam	RT 1/RW 8 Krajan Wetan Pacekelan Kec. Purworejo	Turiman	Manisah
585	Nadine Syifa Kamalia	17	\N	nadine.kamalia	$2y$12$9fgcTfOCEwltvJfH9OD7mucHo.6UWWIYlzMiYIJ09HSYRqONrt3PO	3391	77641762	P	Jakarta	2007-12-20	3172046012070005	Islam	RT 2/RW 7 Jati Salam Semawung Kec. Purworejo	Mochamad Syafei Alm	Salbiyah
588	Putri Novitasari	17	\N	putri.novitasari	$2y$12$YRM782LaHajFke5gLfqEG.yfNMrS22ZloCUB36xAsn91kwjoIzQlC	3394	78519494	P	Purworejo	2007-11-26	3306066611070001	Islam	RT 2/RW 3 Sucen Semawung Kec. Purworejo	Marsaid	Supiyah
608	Ariya Eka Supriyanto	18	\N	ariya.supriyanto	$2y$12$rg5WBIed/wZTuWB5gsr03O7Pts.0e6m89toSZFVn8Svv/Mum1Od9q	3414	82237608	L	Purworejo	2008-07-22	3306042207080001	Islam	RT 3/RW 5 Kebokuning Desa/Kel. Soko Kec. Bagelen	Ponirun	Sugiyem
612	Cahya Aulia Laila	18	\N	cahya.laila	$2y$12$kk.5LnKci6T2xEfPocf3N.TU88S/AJSySpRt0h7c5FKgMsjVz15Yq	3418	84626671	P	Purworejo	2008-01-12	3306045201080001	Islam	RT 1/RW 7 Bojong Desa/Kel. Bapangsari Kec. Bagelen	Shodiq	Aan Yuliani
615	Dewik Multifasari	18	\N	dewik.multifasari	$2y$12$sNZ9kKAztqazHfnzqIknGOBhTWe9QdoUPQOD2xw3M1GStC8eSdonO	3421	95522991	P	Purworejo	2009-01-04	3306064401090002	Islam	RT 2/RW 7  Desa/Kel. Sido Mulyo Kec. Purworejo	Wagiyono	Turinah
618	Intan Puspitasari	18	\N	intan.puspitasari	$2y$12$CQFVbgq.SgMeS3bOmEUyHuOFaTgRHGjXRsj2z94K3aWxWE7hJykwe	3424	87922957	P	Purworejo	2008-02-11	3306045102080001	Islam	RT 1/RW 3 Kedungrejo Sokoagung Kec. Bagelen	Slamet	Suparjiani
621	Lia Latifatun Hasanah	18	\N	lia.hasanah	$2y$12$ki/29A2x6BVj0N4RQgXkqeVdtrkDV0spyAvCHYZmfs61PGXeEKaXq	3427	87198902	P	Purworejo	2008-01-21	3306056101080001	Islam	RT 1/RW 5 Dukuhrejo Somongari Kec. Kaligesing	Parman	Poniyem
624	Melya Firda Sari	18	\N	melya.sari	$2y$12$TyVuFx.eOB1bG1xFVSRXGObAQQqghci7Vn7YlWXYUwa2qdBuFITCi	3430	81336692	P	Purworejo	2008-05-25	3306066505080001	Islam	RT 1/RW 1 Sumberejo Ganggeng Kec. Purworejo	Juli Priyadi	Indrayati
626	Miki Maryanti	18	\N	miki.maryanti	$2y$12$HPBdjcLcu/r.lkKJxPXJJO17KTj2BSulgodDkQ4H4T4wdGEo/hbvC	3432	86125630	P	Purworejo	2008-03-23	3306046303080001	Islam	RT 1/RW 3 Kaliputat Clapar Kec. Bagelen	Tupin	Kasinah
631	Safa Nabil Fashih	18	\N	safa.fashih	$2y$12$cgdsFza.V2KdtZYRSlHyf.NnSX1grBTFRq9XZtcQZgf/XUOPG3y9e	3437	79105004	L	Bekasi	2007-11-15	3306061511070001	Islam	RT 3/RW 4 Semawung Semawung Kec. Purworejo	Saruto	Tutik
633	Sri Fauziah	18	\N	sri.fauziah	$2y$12$N7kNvLRMWQpsa/O86UhS4eRjQWvSLj9SwA6rrhZirsWmqb590832y	3439	83110104	P	Purworejo	2008-02-16	3306065602080001	Islam	RT 3/RW 4 Jambean Desa/Kel. Sidorejo Kec. Purworejo	Catur Pamuji	Siti Rubaingah
639	Andra Syahrani	15	\N	andra.syahrani	$2y$12$8OTgboA01Kl3CFmY9GzJHOzwx2fiHedIclQwMNQ29RmBRQS78BiHO	3301	71406447	L	Purworejo	2007-12-14	3306061412070001	Islam	RT 1/RW 1 Sumberjo Ganggeng Kec. Purworejo	Busono	Siti Rifani
642	Bayu Dimas Ardhani	15	\N	bayu.ardhani	$2y$12$ml48vFyofvXH4CVcqJjWnOvdIb32AsUlM6s6WZ9h1YcR1X6EtRFcO	3304	88444938	L	Purworejo	2008-11-14	3306061411080002	Islam	RT 5/RW 1 Mabean Ganggeng Kec. Purworejo	Tri Agustiyono	Sri Sumarsih
646	Devi Dwi Rahmawati	15	\N	devi.rahmawati	$2y$12$UyWVuKEeRch15XqIkaoD...qGtXzQ6I5bWcKt89/0QCaa/PLr0eDK	3308	67312389	P	Purworejo	2006-12-18	3306065812060002	Islam	RT 3/RW 1 Cangkreplor Cangkrep Lor Kec. Purworejo	Ristiyono	Purwanti
649	Ello Tri Jaya	15	\N	ello.jaya	$2y$12$gvarM7Mt0iHZ2dRgLyDRzO.hwEWi3PRp0whl9uC/VeRJHR9.5.Tvm	3311	82863911	L	Purworejo	2008-02-21	3306062102080001	Islam	RT 3/RW 1  Wonoroto Kec. Purworejo	Parno	Sopiyah
652	Faisal Akbar	15	\N	faisal.akbar	$2y$12$9YcbowhGbIynIbHuIVFKyerM5V5Zs/9Oe8RASsSJP8vWrpkkSsNx.	3314	87310705	L	Purworejo	2008-10-24	3306062410080002	Islam	RT 4/RW 2 Panggulan Desa/Kel. Donorati Kec. Purworejo	Utarto	Rupinah
656	Muhammad Farhan Wibowo	15	\N	muhammad.wibowo	$2y$12$YQHrhsqI2j5HRA9fA3JkIu6DIpz/PVSCf4C3OQgEXSKlpdjM3fwqW	3318	78467790	L	Purworejo	2007-05-07	3306080705070001	Islam	RT 4/RW 1 - Desa/Kel. Sucenjuru Tengah Kec. Bayan	Sutaryanto	Ida Pramesti
659	Novita Widhi Astuti	15	\N	novita.astuti	$2y$12$PNhyxjdcMGTDahQ0iCzNHea8XSUbDxf9vyxT/72LUnmjp9CRhiXP6	3321	74412598	P	Purworejo	2007-11-18	3306045811070001	Islam	RT 1/RW 5 Kebokuning 2 Desa/Kel. Soko Kec. Bagelen	Slamet Widodo	Suyati
662	Raditya Aryabima Dumades	15	\N	raditya.dumades	$2y$12$gZ..ASZzjPjRXKExB/jTke/tdhUbOMl22VKACwAVC0zbZ.JXExtNa	3324	66480014	L	Purworejo	2006-12-25	3216051212060005	Islam	RT 3/RW 1 Kauman Ganggeng Kec. Purworejo	Angga Ramadhany	Riadiningsih
665	Restu Bagas Saputra	15	\N	restu.saputra	$2y$12$vH8aRbwcZHNf1t4kifBepebnXE8yntsnJJ9/53YUD5jD.a5ikrUR.	3327	76253811	L	Purworejo	2007-08-08	3306070808070001	Islam	RT 6/RW 1 Sawioro Desa/Kel. Wangunrejo Kec. Banyu Urip	Margono	Winarsih
669	Susilo	15	\N	susilo	$2y$12$nzo/RU.DNSje17tBudwH2uDlqrOfuActsc4Akt0uCyVrovEQnAtfq	3331	53525616	L	Purworejo	2005-07-28	3306042807050001	Islam	RT 2/RW 4 Karangrejo Kemanukan Kec. Bagelen	Lasasih	Lasasih
672	Wahyu Hidayat Tri Lutfiansah	15	\N	wahyu.lutfiansah	$2y$12$fUwfzvaDlMr8q6b1fc5b6e3qCxhXCgkP2QS0KkQ6CK.EenTedfeSa	3334	86473166	L	Purworejo	2008-03-09	3306110903080001	Islam	RT 8/RW 2 Dk. Kalitan Tersidilor Kec. Pituruh	Mardiyono	Mulyanah
674	Abey Dakaria Putra	16	\N	abey.putra	$2y$12$/5XmqgVBS9uD.yGrK0N/2uviQbtC1ba7EDd4U3fH2lx7/eqFkmSpC	3336	74718938	L	Bekasi	2007-06-13	3216061306070016	Islam	RT 2/RW 1  Desa/Kel. Tambakrejo Kec. Purworejo	Subiyantoro	Siti Rosidah
677	Ahmad Sanusi	16	\N	ahmad.sanusi	$2y$12$bYjxs3gBglJNEoFN31em5urCgNqzqMKG7cIXZT80U.I/qSu5/AYEa	3339	82283858	L	Purworejo	2008-07-08	3306060807080002	Islam	RT 0/RW 0  - Kec. Bagelen		Sri Mulyani
680	Andika Anggi Pratama	16	\N	andika.pratama	$2y$12$Q9y2sdQnFTKz9biD4FsOHONZn.VNgbGXEA5YbCAYGGh.9mQzk1J6K	3342	86955526	L	Purworejo	2008-01-12	3306051201080001	Islam	RT 2/RW 2 Krajan Tlogobulu Kec. Kaligesing	Sucipto	Siti Uswatun Kasanah
683	Asty Maharani	16	\N	asty.maharani	$2y$12$wLL/T7ZwbE4T5BeMdd2NxeC68Npg9q9T/Upm89MqOpuZPbhvw5CWS	3345	86791445	P	Purworejo	2008-04-05	3306054504080002	Islam	RT 1/RW 1 Kradenan Tlogorejo Kec. Kaligesing	Pajar Subowo	Duwi Ariyani
687	Dimas Pratama	16	\N	dimas.pratama	$2y$12$FjvrQs9/WpsQ48nZqell4efDyAX3sSK/xsmKbWv.nQ1UxLLFyKwVq	3349	81269329	L	Purworejo	2008-02-25	3306062502080001	Islam	RT 2/RW 4 Cangkreplor Desa/Kel. Cangkrep Lor Kec. Purworejo	Rudy Prasetyo	Sri Muryani
690	Firhan Tri Wibowo	16	\N	firhan.wibowo	$2y$12$by6qjOFcDXepHiuMq2uV.umDCSKDWeVZB/ZSw1kkIAK6MrEB1alsS	3352	83449326	L	Purworejo	2008-01-02	3306040201080001	Islam	RT 1/RW 3 Kedungrejo Sokoagung Kec. Bagelen	Pujiono	Suminah
80	Alya Fadilla	4	\N	alya.fadilla	$2y$12$aXgX9GqHSCieK5XwL0CvvOvG8HM7Vf4BX4IZGI.ekSbYbUB.yTgcW	3865	93013338	P	Purworejo	2009-10-25	3306076510090002	Islam	RT 1/RW 2 Borotawang Boro Wetan Kec. Banyu Urip	Sutrisno	Ngatijem
31	Neva Agoestina	6	\N	neva.agoestina	$2y$12$E6yUMdkHizMmO5BEGZi7ae4bonbVXIbO32YQXYB8nyLKMKTAbKHSG	3959	97260148	P	Purworejo	2009-08-17	3306065708090001	Islam	RT 2/RW 2 Ganggeng Ganggeng Kec. Purworejo	Novianto	Ernawati
36	Rizka Cahyaningrum	6	\N	rizka.cahyaningrum	$2y$12$GUNQ1t49J6/ZMcwxPoRoDuYl.MbT6Z5slUVPxKjtNSWi5d56E2hcG	3964	109143736	P	Purworejo	2010-03-30	3306157003100001	Islam	RT 3/RW 2 Karangjati Desa/Kel. Karangrejo Kec. Loano	Sriyono	Wagiyati
41	Talitha Puspita Sari	6	\N	talitha.sari	$2y$12$/Q8MBqDopT81BRg79Qsnve2rwmMXoxQDSxRDy7e2gZ80aEVDFOmBS	3969	103710521	P	Depok	2010-01-15	3276105501100006	Islam	RT 6/RW 2 Kahuripan Desa/Kel. Kalirejo Kec. Bagelen	Puji Giyanto	Komsiyah
46	Almira Putri Zakiah	7	\N	almira.zakiah	$2y$12$BurAV61vf85pLRwCdPBP/eKk.GcGTjJRuIeYXqgEtX2fkbAGMQhjC	3974	102737120	P	Purworejo	2010-07-09	3306154907100002	Islam	RT 1/RW 6 Loano Desa/Kel. Loano Kec. Loano	Anik Estiana	Anik Estiana
52	Azka Khoirul Wafi	7	\N	azka.wafi	$2y$12$VNDsj7a85vTaZzKkZhzlTOuv2jXKEmfyqEfgWagG4IH8sH/yAE39y	3980	106916112	L	Purworejo	2010-07-02	3306060207100002	Islam	RT 1/RW 3 Kretek Desa/Kel. Pacekelan Kec. Purworejo	Agus Sugiyanto	Muslihah
57	Dewinta Arsya Fajrina	7	\N	dewinta.fajrina	$2y$12$vdZKhj9kD0FloXKxInEXDeuCTlnRw.oYvQs8PCT8PhMs0JbfWott2	3985	105495743	P	Purworejo	2010-06-08	3306064806100001	Islam	RT 7/RW 7 Desa/Kel. Baledono Kec. Purworejo	Deny Setyawan	Desy Prasetyaningrum
62	Livera Deka Ramadhani	7	\N	livera.ramadhani	$2y$12$aW5lIRdipeWoUmSWt/xbCOoNBqTr.6tqg2E8Qg2xHwIRZTbe2bTHu	3990	3102838139	P	Purworejo	2010-08-28	3306066808100001	Islam	RT 5/RW 3 Projayan Desa/Kel. Cangkrep Kidul Kec. Purworejo	Dwinanto	Sekti Afriani
67	Rafa Nur Azizah	7	\N	rafa.azizah	$2y$12$AKYRzB4AjVuUBByjYfjIWuLHqT3mhQq/ltJ0rlLuvh4nOoVbnwnwa	3995	105510526	P	Purworejo	2010-03-01	3306034103100001	Islam	RT 2/RW 1 Gondang Desa/Kel. Keduren Kec. Purwodadi	Yusuf Saparyanto	Tri Haryani
72	Sholeh Rimanto	7	\N	sholeh.rimanto	$2y$12$a96ZhAqYBexCdJG1RzJS1uKdnVLOeZN8/TU.OlcBifVVCzQeM/pJe	4000	101794183	L	Purworejo	2010-04-28	3306052804100002	Islam	RT 3/RW 4 Sijanur Somongari Kec. Kaligesing	Sumijo	Murni
77	Zelita Altamevia	7	\N	zelita.altamevia	$2y$12$QHoEKn9aCzx4KlaSDn13ZORF5PAEikHnzw.L6Wwr6aBAUfZx5XU.i	4005	99032780	P	Purworejo	2009-12-30	3306067012090001	Islam	RT 1/RW 2 Desa/Kel. Sidorejo Kec. Purworejo	Paryoto	Diyah Windiarti
698	Rangga Satya	16	\N	rangga.satya	$2y$12$qN22BqAN3SQdlq2fizRyNOxPInR7.JyVWTBLQqmHZxkG0ZbxVnRoa	3360	88018931	L	Purworejo	2008-05-06	3306040605080001	Islam	RT 2/RW 4 Gumuk Piji Kec. Bagelen	Priyadi	Ngatirah
701	Sakha Zunnurain	16	\N	sakha.zunnurain	$2y$12$1ay2Z3uBB45JOJowiXGduebRSUiR/7o7GNDGePzam./xfRsrAkmLS	3363	85814335	L	Bogor	2008-01-25	3201042501080003	Islam	RT 2/RW 1 Ngemplak Gintungan Kec. Gebang	Amat Mufarid	Julaeha
704	Solehudin	16	\N	solehudin	$2y$12$.Prf5EM8Y.sSJN3yMV4RMu/WxEy80pN4DSL7F7y8X4DoWOI5pN/9G	3366	61523152	L	Purworejo	2006-10-19	3306041910060001	Islam	RT 2/RW 3 Kibon Piji Kec. Bagelen	Triyono	Ngadinah
706	Tri Raswanto	16	\N	tri.raswanto	$2y$12$moCefyVcBiriSH0pImf4dOFMiy7dcSO3YI8JX4VMAIdIkZHx4Tr3a	3368	73272953	L	Purworejo	2007-04-30	3306063004070001	Islam	RT 2/RW 2  Desa/Kel. Tambakrejo Kec. Purworejo	Supriyanto	Siyam
709	Zsa Zsa Kinanthi Hannaya	16	\N	zsa.hannaya	$2y$12$4Idh6/towQGGzsnkR4EJuu4.3OWgltMQTIyv9.GSrmOqBD9lQ6B2i	3371	84117721	P	Purworejo	2008-03-29	3306046903080001	Islam	RT 2/RW 2 Sekangun Sokoagung Kec. Bagelen	Sarwoto Tinoyo	Sumarti
153	Achmad Zidan	1	\N	achmad.zidan	$2y$12$2U6wj.KyZ4MbsvYDphdvFOOyFZmXOi7CNqwTrHedTl8hB3Zj0671.	3759	103838137	L	Purworejo	2010-01-30	3306053001100001	Islam	RT 1/RW 3 Sewu Desa/Kel. Kedunggubah Kec. Kaligesing	Supardi	Sutriyanti
158	Daffa Rizqi Khoirun Nasywa	1	\N	daffa.nasywa	$2y$12$hJ0EjpKLP.b0j5I/IKnZwepgh7ZPckFggx1eOlZ5H930d5HEqMy7e	3764		L		\N					
161	Didi Rahma Putra	1	\N	didi.putra	$2y$12$jCTCbKiAZ1RtUQaJ0cyt8u9wfoVKh5eh4V5DM29bCSk5ChhRd6KXi	3767	109200476	L	Purworejo	2010-01-05	3306060501100001	Islam	RT 2/RW 1 Karang Kulon Desa/Kel. Wonoroto Kec. Purworejo	Margono	Sariyah
166	Gian Rafa Fritzi	1	\N	gian.fritzi	$2y$12$qJ2xNLPTUUc.ajuL6Df8Ze30efMSkkCFZy54fvL1.dTGBriWhksha	3772	108059960	L	Purworejo	2010-01-19	3,20102E+15	Islam	RT 3/RW 4 Baledono Baledono Kec. Purworejo	Alif	Retno Wigati
171	Muchamad Ajie Pamungkas	1	\N	muchamad.pamungkas	$2y$12$iYgqpExc3oI07.FbcvgwlubZsM..WHcu00yLNmPrZkq/YK10DwHhO	3777	95278253	L	Purworejo	2009-10-22	3306062210090004	Islam	RT 2/RW 2 Ngawang Awang Desa/Kel. Brenggong Kec. Purworejo	Arokhman	Jumiati
175	Rafiq Nur Hidayat	1	\N	rafiq.hidayat	$2y$12$wAtZ1kbUgPJbScdof0OXNek574zWWp6gb.ox4MsoFRwHuLcfouZK6	3781	108432545	L	Purworejo	2010-05-13	3306061305100002	Islam	RT 4/RW 1 Bokongan Desa/Kel. Sidorejo Kec. Purworejo	Paryono	Sutini
180	Rizky Ramadhan	1	\N	rizky.ramadhan	$2y$12$iwmmStYo3OGFdXyod0VSXOtUk.cUQ8JOKdN9GZZXDzst/9Tf.h2B.	3786	97052279	L	Purworejo	2009-09-02	3306060209090002	Islam	RT 2/RW 8 Desa/Kel. Tambakrejo Kec. Purworejo	Yamin	Yuliani
185	Zidni Alfa Mubarok	1	\N	zidni.mubarok	$2y$12$Ou1ylNQ5yFkj/NQX/gcX9OpIXtdqRz2LUjphnzlTVLpDex5S7j9ny	3791	3103043568	L	Purworejo	2010-04-16	3306061604100001	Islam	RT 2/RW 4 Desa/Kel. Brenggong Kec. Purworejo	Amat Kusen	Rochaniyah
188	Ahmad Dzaky Faturrohman	2	\N	ahmad.faturrohman	$2y$12$spBTyGzfaC7YncxFx36dE.h9AvswWnQELr/b3CyLLd4su2Iz24gFK	3794		L		\N					
193	Aufaa Shafiyyul Rizki	2	\N	aufaa.rizki	$2y$12$mXrKPSeZmdyzN28igrXIDuh4J3NtRu5hQbuLQSKKsUJ/jCJ8rDQdi	3799	92492106	L	Purworejo	2009-05-13	3306041305090001	Islam	RT 2/RW 2 Krajan Wetan Desa/Kel. Kemanukan Kec. Bagelen	Saryadi	Yuli Utami
83	Asa Ananda Rizky	4	\N	asa.rizky	$2y$12$0hRnzJ63NlnZIdStCg85deVpubT80hNhiz.nb7oYfaNaQBpXGrMpK	3868	107787431	P	Purworejo	2010-04-26	3306066604100001	Islam	RT 1/RW 2 Kembaran Desa/Kel. Semawung Kec. Purworejo	Haryanto	Nur Paryanti
91	Enike Nur Fatimah	4	\N	enike.fatimah	$2y$12$kwuQWqhfEs.a7HHaQ.p4L.QLdQJy.J428p1PRRojDky3Vwea5IoFS	3876	106273866	P	Purworejo	2010-09-16	3306065609100002	Islam	RT 2/RW 3 Kedung Sari Kec. Purworejo	Sunaryo	Supiah
93	Jevanie Aznatria	4	\N	jevanie.aznatria	$2y$12$3avXNauFYpLRG/HSqMz9fOIlgZdn6JENo2AlJJuEAr0rHrf6EKs5q	3878	105899558	P	Purworejo	2010-07-23	3306036307100001	Islam	RT 3/RW 5 Kriyan Rt 003 Rw 005, Ketangi, Purwodadi Desa/Kel. Ketangi Kec. Purwodadi	Tri Setijanto	Tatik Asnawati
98	Nabila Khairunnisa	4	\N	nabila.khairunnisa	$2y$12$Mml3oe1vsWGuP7OohDzxm.P3IpgKFSdjBVEw.FJFme5tRhkJpy6Km	3883	104730641	P	Purworejo	2010-04-10	3306065004100001	Islam	RT 3/RW 3 Regonayan Desa/Kel. Cangkrep Lor Kec. Purworejo	Bejo Santoso	Siti Fadilah
104	Olivia Dwi Okta Riyani	4	\N	olivia.riyani	$2y$12$XjKLjuFsAMfWeCPI7K77A.8Ov5Jafa5DX1m4GvhGGhGVZxBCYWlRu	3889	108920277	P	Purworejo	2010-10-17	3306045710100001	Islam	RT 3/RW 5 Pucungan Bapangsari Kec. Bagelen	Wasito	Wasiyah
109	Shifa Rizky Alifia	4	\N	shifa.alifia	$2y$12$XRzE8EXvTEpX3eDGP.FwJuIc/cJv.LOd5..1nFa.k1Jq0o4aMrBC2	3894	105115202	P	Purworejo	2010-03-15	3306055503100001	Islam	RT 7/RW 1 Katerban Donorejo Kec. Kaligesing	Sunaryo	Maryana
114	Zita Anggraini	4	\N	zita.anggraini	$2y$12$G0/Mn/H/cjxmmZ3pT//kbehbWcF4Q2Gb2c4J1/S7NUvkOr1aQHUpW	3899		P	Purworejo	2009-12-06		Islam	RT 009/ RW 002 Wonogiri Desa Tawangsari, Kec. Kaligesing Kab. Purworejo	Suwito	Siti Fatimah
119	Aurora Saffalia	5	\N	aurora.saffalia	$2y$12$EXIhpTI4anbrg3hsREYFnOnQ2lDUk1dB4.v2VtPSFXtPrX3YgIKtO	3904	105638853	P	Purworejo	2010-03-23	3306056303100002	Islam	RT 12/RW 3 Sigayang Desa/Kel. Jatirejo Kec. Kaligesing	Ujiono	Wasilah
124	Dinda Putri Juliana	5	\N	dinda.juliana	$2y$12$h9n4iyWHFo0Le3cGRm3iGOTKj6zlauxc6pwP1brCX59Zs/n8qK/Gu	3909	109094004	P	Purworejo	2010-07-07	3306044707100003	Islam	RT 3/RW 2 Sijo Semono Kec. Bagelen	Purwanto	Tusri Wulandari
129	Dwi Laela Saputri	5	\N	dwi.saputri	$2y$12$ZNvoTxujcN2mOT08s/hucOOcGh/xuTEgEoBSc3xG79ysNHwpOpFcW	3914	107047297	P	Purworejo	2010-03-17	3306045703100001	Islam	RT 3/RW 3 Karang Sari Desa/Kel. Kemanukan Kec. Bagelen	Sarjono	Suyatmi
134	Mila Kurnia Dewi	5	\N	mila.dewi	$2y$12$kAgPa7owWUkcbVcQRc0rq.aXqbsz/bm/NlEg3fZ4h7BZdrPr9hPKC	3919	102995159	P	Purworejo	2010-03-27	3306056703100001	Islam	RT 1/RW 4 Munggangrejo Desa/Kel. Hulosobo Kec. Kaligesing	Tekat Haryanto	Saodah
139	Nida Nafisah	5	\N	nida.nafisah	$2y$12$lA075RdS/UCCyBASn1BMG.mBQOlcFXkOgT84EnC0YPaAeeoRME/nm	3924		P	Purworejo	2009-11-04		Islam	RT 05/ RW 01 Durensari, Kec. Bagelen Kab. Purworejo	Wahyudi	
143	Putik Dukhi Arasih	5	\N	putik.arasih	$2y$12$p9KCCgG3kcOPo.E5pC8zG.5y4CvhCcytz/NGKCweiwm6dfcV3mt/W	3928	107548134	P	Purworejo	2010-03-05	3306074503100002	Islam	RT 1/RW 3 Tawang Borowetan Kec. Banyu Urip	Subrik Abady	Ngayem
148	Sri Panuntun	5	\N	sri.panuntun	$2y$12$kqMEkBpMZJYHw2AJbi74Xey3kt7cseAoKk0/hrRJz3kkVYLAddLPW	3933	102596964	P	Purworejo	2010-07-13	6304175307100001	Islam	RT 11/RW 4 Durensari Desa/Kel. Durensari Kec. Bagelen	Dasim Daryanto	Sarti
258	Adella Putri Hidayati Nurdin	13	\N	adella.nurdin	$2y$12$7VniAmGdkOLipWU5S1JvP.xUOhHGnie01nuBR133r99lPwa8Rucpe	3687	96761199	P	Purworejo	2009-05-05	3306154505090002	Islam	RT 1/RW 7 Krasak Mudalrejo Kec. Loano	Dendi Riyanto	Nur Khayatiningsih
262	Angger Lisnawati Derista Utami	13	\N	angger.utami	$2y$12$.dXie3tnYofO42vjfNeY5eWomZrUi276z92oNZ9BLai6IxE1X54tC	3691	81051225	P	Purworejo	2008-12-25	3306066512080003	Islam	RT 3/RW 3 Projayan Cangkrep Kidul Kec. Purworejo	Gunawan	Tri Sulistiyanti
268	Devina Nuraini	13	\N	devina.nuraini	$2y$12$bBckJKE1zUN0xfEXV0KNZ.ZgBV5qr8DjkeUfzMPtg2hwUQKAPsQPC	3697	94268491	P	Purworejo	2009-01-15	3306045501090001	Islam	RT 1/RW 4 Karangrejo Kemanukan Kec. Bagelen	Darminta	Eti Mulyani Sari Rahayu
273	Fuji Suryaningsih	13	\N	fuji.suryaningsih	$2y$12$Xc7.J2pqxS9jkf/fxm8OOeG00APXEj3qJe2PO.woxgss0MVawmSu6	3702	92754236	P	Purworejo	2009-01-23	3306046301090003	Islam	RT 1/RW 2 Sijo SEMONO Kec. Bagelen	Kaswanto	Warsih
276	Isabitha Wulandari	13	\N	isabitha.wulandari	$2y$12$X4JJ3gzTeh52.m6VZi2lJu61ihPrb3VkS/qUT3JJCvT18.KTdqFiy	3705	3085457272	P	Purworejo	2008-07-31	3306167107080001	Islam	RT 2/RW 2 Bener - Kec. Bener	Ismanto	Suranti
281	Muhammad Rizqi Latif	13	\N	muhammad.latif	$2y$12$aC7/L2dRjJ8bAo54AesfrenNDFZ0gPVrlzrvnYDNW/o5.l.bK0/aG	3710	97430864	L	Purworejo	2009-08-01	3306060108090001	Islam	RT 1/RW 8  Desa/Kel. Baledono Kec. Purworejo	Giyono	Parsih
286	Retno Wahyu Ningrum	13	\N	retno.ningrum	$2y$12$2W62tdnGT.qlR/2NJBSawOqAiUNno14ViCEtR9Y5lh98H72Lpmx9G	3715	106918090	P	Purworejo	2010-01-04	3306044401100001	Islam	RT 2/RW 5 Tepus Somorejo Kec. Bagelen	Agus Purnomo	Nur Hasanah
291	Umi Latifah	13	\N	umi.latifah	$2y$12$So4Eg5zb7DLLr/3bSDfW0OIDMTEmKhsSPgJMh.BwmSP732gzBsrVG	3720	97094080	P	Purworejo	2009-01-29	3306056901090001	Islam	RT 5/RW 1 Krajan Somongari Kec. Kaligesing	Suyono	Wartini
296	Devina Meilani	14	\N	devina.meilani	$2y$12$hZj2os2qenKCokUDNiSoruJI9S1w9qxa2EUj30sHJIGO0Qpa4y3QG	3725	98264799	P	Purworejo	2009-05-18	3306045805090001	Islam	RT 1/RW 1 Clapar Kidul Desa/Kel. Clapar Kec. Bagelen	Jumakir	Fiki Lia Handayani
301	Jesica Ayu Putri	14	\N	jesica.putri	$2y$12$mqjBfJTYN5mWQU20/qkj6OOlTmyaTyMHBiEzXM6RgRHjFWCL9J9Vm	3730	94749183	P	Jombang	2009-03-14	3517115403090003	Islam	RT 1/RW 1 Sumberjo Desa/Kel. Ganggeng Kec. Purworejo	Yosi Rudi	Rosidah
306	Lita Adiya	14	\N	lita.adiya	$2y$12$IDtZUk3Zv4r4vTssrD/Ww.TD6BGQv1hAg5dB6wTr8ZTbI4cCxIjtm	3735	93232886	P	Kebumen	2009-02-01	3305214102090003	Islam	RT 4/RW 2 Donorati Donorati Kec. Purworejo	Koiri Nuradi	Supriyani
312	Nur Hidayah Juliana	14	\N	nur.juliana	$2y$12$XH/N7qTjFOiDdJ4QzakKbeHyFqwLP4See4AAa0bgetUNGUcjXT1X2	3741	95486688	P	Purworejo	2009-07-12	3306055207090002	Islam	RT 3/RW 3 Jeketro Desa/Kel. Kaligono Kec. Kaligesing	Siswanto	Supriani
317	Ratri Dwi Oktarini	14	\N	ratri.oktarini	$2y$12$xj/qxhNfkPaa.wqWIbByeOdcC.vA.iUFVAxH1JcSolUCJ4dJYrf/6	3746	89603442	P	Purworejo	2008-10-25	3306076510080003	Islam	RT 4/RW 1 Krajan Desa/Kel. Bencorejo Kec. Cengkareng	Endang Kurniawan	Dwi Budi Lestari
325	Wening Fajria Wigati	14	\N	wening.wigati	$2y$12$v365USGsUScpSsS82RKu/uT7z8jp87ts4hSITtQ7qOz3eWaCr6XSO	3754	85199856	P	Purworejo	2008-10-16	3306035610080003	Islam	RT 1/RW 6 Candi JENARWETAN Kec. Purwodadi	Kuswanto	Suwanti
322	Syifa Lutfiana Jahra	14	\N	syifa.jahra	$2y$12$RssJkLMLzaLJt1hOJlM2Fe90WU/9J9BFC5wbB2BHNW.RHIX9AhYE2	3749	81556691	P	Purworejo	2008-12-16	3306035612080001	Islam	RT 8/RW 3 Bubutan Desa/Kel. Bubutan Kec. Purwodadi	Edi Sugianto	Dewi Rahayuningsih
198	Fathurrahman	2	\N	fathurrahman	$2y$12$bPRK/7s52g45Le286uSdD.kEkqInQg4Z.7MfpqrVYpQJefiCuw5IO	3804	102686647	L	Purworejo	2010-05-12	3306031205100001	Islam	RT 1/RW 2 Desa/Kel. Sidoharjo Kec. Purwodadi	Kadarisman	Zubaidah
203	Ilham Maulana	2	\N	ilham.maulana	$2y$12$2bj8oTZge8ddR1UTLwt4IeHMbtsU43SXHgWShCFrcM7SeVGIRiAHC	3809	104251397	L	Purworejo	2010-03-06	3306060603100002	Islam	RT 2/RW 7 Desa/Kel. Purworejo Kec. Purworejo	Arif Triyono	Maemonah
208	Muhammad Salman Taufik	2	\N	muhammad.taufik	$2y$12$rKm18FYpnu0AkHP2kQNCEeGftDviWeee/VZPUb621wedZtOQnbD6G	3814	86400083	L	Purworejo	2008-11-26	3306062611080002	Islam	RT 1/RW 6 Desa/Kel. Tambakrejo Kec. Purworejo	Muhammad Taufik Nuryadi	Partiyah
214	Restu Gilang Satriyo	2	\N	restu.satriyo	$2y$12$hdOPw3meAh22QN9Yu0.cRuv8Xk06W7BC8r7ZYuNDjdSB.Sz9matHG	3820	95069736	L	Purworejo	2009-12-04	3306140412090001	Islam	RT 2/RW 2 Kroyo Kroyo Kec. Gebang	Triyono	Sri Haryati
216	Syifa Kharisma Putri	2	\N	syifa.putri	$2y$12$vIMnJA0h3ZZh5nkK6qtZveZmnDGuIh832Xid2JPIIvxX6bWFnS.hW	3822	93639999	P	Purworejo	2009-04-13	3306145304090002	Islam	RT 2/RW 3 Silendung Penungkulan Kec. Gebang	Eko Mintaryo	Mei Wulandari
221	Zalfa Yoselin Firdaus	2	\N	zalfa.firdaus	$2y$12$JG03j9vZZAxvEaOEKbbXtecqFYK2X7MajAJ1fsOxtpSGUU5xISEsO	3827	102355273	P	Purworejo	2010-04-08	3306064804100001	Islam	RT 3/RW 4 Loano Desa/Kel. Loano Kec. Loano	Yulian Oriza Firdaus	Solihah Aisah
229	Arini Yuniarti	3	\N	arini.yuniarti	$2y$12$CF3ras3emO2.caTs/6LlrePYZHImjqGmRO2ATwCfc.Ba437m36gMS	3835	127391350	P	Purworejo	2011-06-01	3306064106110004	Islam	RT 2/RW 7 Gunung Butak Desa/Kel. Pacekelan Kec. Purworejo	Suroso	Wagiarti
232	Dawam Mulya Alfauzan	3	\N	dawam.alfauzan	$2y$12$NTTbzfJXJw9elD6v/QAn.OL0k5smgeJbMGpdd.K4b4IQziwPeyXJq	3838	96445873	L	Purworejo	2009-02-20	3306052002090001	Islam	RT 1/RW 1 Krajan Desa/Kel. Somongari Kec. Kaligesing	Suroto Eko Yuwono	Helmawati
239	Ilham Muxti Ajhi Pratama	3	\N	ilham.pratama	$2y$12$5MF3EGdDluqtWO7OuKmFO.1ky2jaUyuKLH1e.RI2yC45ze0zPPBKi	3845	3100893084	L	Purworejo	2010-01-09	3306080901100005	Islam	RT 0/RW 0 - - Kec. Bayan		Esti Rahayu
242	Muhammad Faqih Hilmi	3	\N	muhammad.hilmi	$2y$12$.12RzBErPAqhRG22LaFlu.7O1nQoEhDHhAuXwy8lfoaFSwKgVm3R2	3848	101664275	L	Purworejo	2010-06-14	3306061406100001	Islam	RT 2/RW 2 Kembaran Semawung Kec. Purworejo	Muhammad Zarkasi	Rofi'Ah
247	Nafis Prasetyo Setiaji	3	\N	nafis.setiaji	$2y$12$NOxu3YUUbqqQUSpeOSqG5uIvuvSHCN/LEOEF8swWAXi86PRL7ckGS	3853	88957245	L	Purworejo	2008-11-14	3306061411080001	Islam	RT 7/RW 5 Ngentak Desa/Kel. Baledono Kec. Purworejo	Heri Radiyanto	Maryatun
252	Tria Oriza Putri	3	\N	tria.putri	$2y$12$A0gYmfaHl7u7xVoQlksE/epaAey5109yzesHlK0U8jE6rIqGP4s7S	3858	94744204	P	Purworejo	2009-05-18	3306065805090001	Islam	RT 2/RW 3 Jurangjero Sidorejo Kec. Purworejo	Patriatmoko	Pariyah
257	Wildan Februrozzaq	3	\N	wildan.februrozzaq	$2y$12$qbxhmXcQ8xSQKXJeC4T3oeC9h6pbiCvAZI6Fs5PKoq8OnLmK7L9Cy	3863		L		\N					
402	Deby Bayu Pamungkas	8	\N	deby.pamungkas	$2y$12$XITVO1SJf8l1CPtdVcUvLOrPPhONvJmijcFqDntKZuJoAgYVtLa4C	3521	97144719	L	Purworejo	2009-03-05	3306060503090004	Islam	RT 3/RW 7  Desa/Kel. Baledono Kec. Purworejo	Agus Supriyoto	Ratmiyati
407	Farid Yusuf Kurniawan	8	\N	farid.kurniawan	$2y$12$esh3FAMa.tihN959Xr6GoO6eIEV2AYwkayQgxeSFDs4YHe28yHnuO	3526	97500327	L	Purworejo	2009-03-17	3306061703090002	Islam	RT 2/RW 1  Sindurjan Kec. Purworejo	Mashudi	Yulimah
410	Habib Puja Prasetya	8	\N	habib.prasetya	$2y$12$DMwdHJ0OZyYsE5HM.ed4/uVH4iE.9uqpwXBcgvcZwe1bJD5VjqnIG	3529	83999947	L	Lamongan	2008-11-05	3671020511080005	Islam	RT 6/RW 1 Dremosari I Durensari Kec. Bagelen	Kasdi	Etik Rubiyanti
415	Muhammad Asyraf Sadewa	8	\N	muhammad.sadewa	$2y$12$toa8Mqs43qGWPryNxQK.P.yf0UdmC/smxYEe5k4AC0vgpq40YWQmy	3534	88961408	L	Purworejo	2008-11-23	3306062311080004	Islam	RT 3/RW 10 Baledono Baledono Kec. Purworejo	Muchamad Muchlis	Nia Agustina
437	Arza Rayhan Ramadhan	9	\N	arza.ramadhan	$2y$12$Osvj4Va7k609qqphI9STGuEQGSfdebbLJlnCNVbfJwWfjQKCbVajC	3556	89814805	L	Purworejo	2008-09-03	3306150309080001	Islam	RT 1/RW 3 Kedungdowo Kulon Trirejo Kec. Loano	Setyo Purnomo	Sri Mujiati
439	Dwi Alfianto	9	\N	dwi.alfianto	$2y$12$CVRxrXNEpD91i5/44EGMSOYCyozW8Y.sFrxHxi0SL3YucgYWaxMVC	3558	94616138	L	Purworejo	2009-04-11	3306061104090001	Islam	RT 3/RW 5 Limus Desa/Kel. Kedung Sari Kec. Purworejo	Paiman	Parningsih
441	Farkhan Maulana Saputra	9	\N	farkhan.saputra	$2y$12$E29BuUiX2z4O2zDkFJo5yurgbWgCiSRKR6RTEfoU.WjktUPZCw.sy	3560	95524604	L	Purworejo	2009-06-22	3306042206090003	Islam	RT 1/RW 2 Krajan Wetan Kemanukan Kec. Bagelen	Sudarsono	Anik Rahmawati
444	Ibram Mahya Adim	9	\N	ibram.adim	$2y$12$.uyEK3XoeNPKa7uKSKEdZ.x/Om0Qw2DMIWqTRAJV0EKSSgh2oGj4W	3563	93052920	L	Purworejo	2009-11-10	3306071011090003	Islam	RT 2/RW 2 Borotawang Borowetan Kec. Banyu Urip	Lisajidin	Dwi Endah Yuliawati
447	Jibran Pandu Pratama	9	\N	jibran.pratama	$2y$12$0N9lxaC4uyPVs86xDcyHO.mnGY0IzV0/DWQoPitFSmxkt/4NTnXLm	3566	72085313	L	Purworejo	2007-02-04	3306060402070001	Islam	RT 4/RW 1 Krandon Desa/Kel. Cangkrep Kidul Kec. Purworejo	Suwarno	Safitri
449	Mohamad Hafiz Silmi Nur Fadhil	9	\N	mohamad.fadhil	$2y$12$J2VtjioHhYvtNFMMQG/kmelwSWf/c3l/KBYrGdHBDDupY6CJuKJpy	3568	82211667	L	Purworejo	2008-11-24	3306072411080001	Islam	RT 2/RW 4 Onggosaran Jenar Lor Kec. Purwodadi	Minarso	Asmuriah
452	Muhammad Januar Setiawan	9	\N	muhammad.setiawan	$2y$12$FZe2WziJW9FakcA.9EyESujJA.Y8TT4FLrcdbnjwDmacKMuUn7zzG	3571	98992225	L	Purworejo	2009-01-11	3306041101090001	Islam	RT 3/RW 1 Krajan Kulon Kemanukan Kec. Bagelen	Apriyanto	Suminah
454	Nur Dzakiyah Qurrotu Aini	9	\N	nur.aini	$2y$12$ME7bSC/dZk5LJQJQ/9K7XumG1WDIaya7uRSXutVGQqeWtQGpGSXvK	3573	87692453	P	Purworejo	2008-04-02	3306064204080002	Islam	RT 1/RW 6 Tambakrejo Desa/Kel. Tambakrejo Kec. Purworejo	Nur Rochim	Lia Nita Indriani
460	Syarif Hidayatulloh	9	\N	syarif.hidayatulloh	$2y$12$N4Vd0GswABMEtg2fKYEBweLNduMBGk7q1vgISbBBhp7wXnI..v4Zu	3579	96865727	L	Purworejo	2009-04-25	3306142504090001	Islam	RT 2/RW 7  Gintungan Kec. Gebang	Sanen	Tentrem Ekowati
465	Akbar Kurniawan	10	\N	akbar.kurniawan	$2y$12$xV5ApSu3c9TUw/OabqxCyelePphFhsW3us/yhXJf//QR1GngDP9I6	3584	87959633	L	Purworejo	2009-01-14	3306041401090001	Islam	RT 2/RW 3 Mejing Rt 002 Rw 003, Somorejo, Bagelen, Purworejo Desa/Kel. Somorejo Kec. Bagelen	Rajikun	Sulasiyah
470	Cahyo Aji Nugraha	10	\N	cahyo.nugraha	$2y$12$eu3PZ/QVAXbg9eJpjMU9P.c8vQ6LZJp59EM9rv5cbpVAGZ40v3vdy	3589	89691162	L	Jakarta	2008-12-27	3306042712080001	Islam	RT 3/RW 4 Gumuk Piji Kec. Bagelen	Karyono	Supriyati
337	Gita Tri Hapsari	11	\N	gita.hapsari	$2y$12$bCwL.CMdZNyP45uhhfdRmeTdJ6i86spurFiXh726TihwUBINF/lzC	3627	97119984	P	Purworejo	2009-02-07	3306064702090003	Islam	RT 5/RW 3 Cangkrep Kidul Desa/Kel. Cangkrep Kidul Kec. Purworejo	Sugito	Sutriyani
343	Melinda Putriyani	11	\N	melinda.putriyani	$2y$12$R2nv6y35V5qUc6vbE4Tyw.PjVpAdF62OMpk6mPfULjxtuPGyuqphm	3633	99227647	P	Kulon Progo	2009-05-27	3401016705090002	Islam	RT 1/RW 4 Krendetan Krendetan Kec. Bagelen	Royani	Tri Supriyanti
346	Noviana Putri	11	\N	noviana.putri	$2y$12$XO7p3B2CFXnqyVnjs374EOI4X3UJyhMWgURypPeBNIZgBMFfTgEPi	3636	86360290	P	Purworejo	2008-11-01	3306084111080001	Islam	RT 1/RW 2 Pucangagung Pucang Agung Kec. Bayan	Suprayitno	Mistun
351	Ricka Dyah Avrelya	11	\N	ricka.avrelya	$2y$12$cKbDGuQDM25w3MvhVm6hUOaU.LFK/jNus19UpKnZX/91RQdbnKF5q	3641	96361270	P	Purworejo	2009-04-05	3306044504090001	Islam	RT 1/RW 1 Krajan SEMONO Kec. Bagelen	Parwadi	Kholimah
356	Syifa Auliya	11	\N	syifa.auliya	$2y$12$ao3fCOEuICqmXBX6an1WveS2RrAMVgMID/8INCTPhFfi8nqiVfA62	3645	99245748	P	Purworejo	2009-02-19	3306045902090001	Islam	RT 2/RW 1 Semawung Desa/Kel. Krendetan Kec. Bagelen	Karyanto	Any Sutriyaningsih
361	Zulfa Meysa Herwanto	11	\N	zulfa.herwanto	$2y$12$XbGjjnxAU2jxBOH5XIIqPebMrqH0cLUerKF3tM2dkQenNzH41cZGi	3650	94789899	P	Purworejo	2009-06-24	3173016406091008	Islam	RT 7/RW 10 Cikarang Cempaka Kec. Cisoka	Riswanto	Suheriyah
366	Ayu Shifa Nurila Putri	12	\N	ayu.putri	$2y$12$J2oOsLwRw2/f5mxh2YfItOZ0JFsadbWHP3OSG.fszSTIFLVKzTxM.	3655	97942397	P	Bekasi	2009-01-23	3275026301090005	Islam	RT 4/RW 1 Keposong Desa/Kel. Krendetan Kec. Bagelen	Toto Tumarno	Karlinawati
371	Fibrilia Syifarani	12	\N	fibrilia.syifarani	$2y$12$ApPY6rOxAvGbD7t5PlbXFujMce2TzmWRTCRbGed.24GiIhENbGVOa	3660	3108666582	P	Purworejo	2010-02-06	3306034602100001	Islam	RT 1/RW 1  Desa/Kel. Kebonsari Kec. Purwodadi	Miftachul Huda	Listiyatun
377	Novi Susiyanti	12	\N	novi.susiyanti	$2y$12$EHFnXGDS52j96L3WLlYzXuzoiF5JgFxunl17DonYYb3tqegZNZTGC	3667	83153347	P	Purworejo	2008-11-26	3306066611080001	Islam	RT 5/RW 2 Majan Wonoroto Kec. Purworejo	Rudi Darmawan	Venti Fatimah
382	Risa Yuliana	12	\N	risa.yuliana	$2y$12$91TMUwLNTxubBtBucw2l1OUjvC7lzkdBX75vqK8n3QJvPMdjc5/Py	3672	88953006	P	Tangerang	2008-07-13	3603125307080013	Islam	RT 2/RW 1 Krajan SEMONO Kec. Bagelen	Bisono	Harwani
384	Riyani Sabila Awalin	12	\N	riyani.awalin	$2y$12$sEyLkyG.4lB2xPemfKrp7.ZhNKkRUdxKMYygdP7FnIUA8REL40yxW	3674	98479531	P	Purworejo	2009-07-09	3306064907090002	Islam	RT 2/RW 8 Babahan Sido Mulyo Kec. Purworejo	Heri	Siti Handayani
389	Silfara Nia Ramadhani	12	\N	silfara.ramadhani	$2y$12$mLVZ8ZPR9x/VahIDmL3.E.hH013tNy9GnJJimPs1YpdPWKft4RXXu	3679	85392167	P	Purworejo	2008-09-21	3306066109080001	Islam	RT 2/RW 2 Klepu Pandanrejo Kec. Kaligesing	Suristiawan	Misyanti
395	Zahwa Oktavia Lestari	12	\N	zahwa.lestari	$2y$12$r.H96U1PBENj/1deWkdWFep1nNlukei7GVLIHPGMB5gi2f6SK.1wK	3685	83727675	P	Pati	2008-10-13	3604115310080001	Islam	RT 3/RW 4 Sorogenen Desa/Kel. Kalijambe Kec. Bener	Eri Wibowo	Sri Lestari
502	Attaya Qesya Putri	19	\N	attaya.putri	$2y$12$vUv8B1jduK9tEcVYd7ModeuIN1DkSwo3mH/LarHIvw/sL79Lu9ToW	3451	86336844	P	Purworejo	2008-06-08	3306034806080001	Islam	RT 2/RW 3 Keng-Keng Desa/Kel. Bragolan Kec. Purwodadi	Marwoto	Rusyanti
507	Dwi Astuti	19	\N	dwi.astuti1	$2y$12$iruLgmhAMUrUVSp7Qqd20OQRstsVb8pn4POlNWmF4Jw33.oUn175O	3456	89721248	P	Kebumen	2008-07-16	3305265607000002	Islam	RT 4/RW 2 Kalipuru Pujotirto Kec. Karangsambung	Suharno	Musiti
512	Indri Syaharani	19	\N	indri.syaharani	$2y$12$XlSCyE.hu2quFhH524689Og.2aU4Dr3aetfN9F930AWPX5Kl8zaS.	3461	84016386	P	Purworejo	2008-03-03	3306044303080001	Islam	RT 1/RW 8 Kalimaro Desa/Kel. Bapangsari Kec. Bagelen	Sukino	Suparnik
515	Lana Ulfa Azizah	19	\N	lana.azizah	$2y$12$51.ghdRYXEwZgmsBTFLBVevLhtl6goWTrh/87YSX3IkVro.P.bPle	3464	82273070	P	Purworejo	2008-07-12	3303065207080002	Islam	RT 2/RW 2 Nadri Desa/Kel. Krendetan Kec. Bagelen	Narisun	Baroyah
518	Malika Dewi Septiana	19	\N	malika.septiana	$2y$12$8r3I7XHLLFNSz5Q.DvPSjO2EdDu0K6eLg9LjzgiJS1U4DxaVOimUu	3467	85652670	P	Purworejo	2008-09-15	3306065509080002	Islam	RT 5/RW 1 Mabean Desa/Kel. Ganggeng Kec. Purworejo	Sri Wahyono	Amalin Atiqoh
521	Navila Agustin Setyowati	19	\N	navila.setyowati	$2y$12$LT0iIvf35xBq3h/W7v.pHOJsLNGpAC2UMp/SD0BW6V51Ynw6iB8by	3470	79374236	P	Purworejo	2008-01-13	3306045301080003	Islam	RT 1/RW 6 Mejing Somorejo Kec. Bagelen	Agus Riyanto	Yustini
527	Tri Yuliana Ristiyanti	19	\N	tri.ristiyanti	$2y$12$tuH1du6pkOB5GfPxZAxr5.Xh/KWmLQZ4jg12RTBv5yF1n2hUHiGz6	3476	73356203	P	Purworejo	2007-07-20	3306066007070002	Islam	RT 3/RW 7 Sidomulyo Desa/Kel. Sido Mulyo Kec. Purworejo	Paimin	Supiah
532	Arinda Hanes Triandini	20	\N	arinda.triandini	$2y$12$ldpnxUAqGXfy6VOiarWbgew9/xHzp5216QUBDYxJz5FdlCy6CKPyK	3481	89713065	P	Purworejo	2008-04-18	3306065804080002	Islam	RT 3/RW 2 Paculan Ganggeng Kec. Purworejo	Marmono	Parini
537	Azzahra Amelia Giovani	20	\N	azzahra.giovani	$2y$12$0d5..uOXnleceiJ9E/oyROQ78HEtIeqfxPmRt6RW4moN5FNdqxz.u	3486	84469820	P	Karanganyar	2008-02-21	3216096102080001	Islam	RT 28/RW 12  Karang Raharja Kec. Cikarang Utara	Suwarto	Suyanti
543	Eka Maesyaroh	20	\N	eka.maesyaroh	$2y$12$m5JisKNathxloTzBVO/T9.hm1rl6YR64m0ZKVViT5KdPDlzb0zO2a	3492	72115214	P	Purworejo	2007-08-15	3306055508070001	Islam	RT 2/RW 3 Sewu Desa/Kel. Kedunggubah Kec. Kaligesing	Wagiman Susilo	Rini Astuti
547	Fellysha Alifya Laura Yudhanto	20	\N	fellysha.yudhanto	$2y$12$2xBOWl1brNwbPy397crZU.8YF1mVdGFb2s2rpOuj.HQuSzqJStaxG	3496	86899706	P	Purworejo	2008-04-05	3306034504080001	Islam	RT 3/RW 2 Purwodadi Desa/Kel. Purwodadi Kec. Purwodadi	Fajar Catur Yudhanto	Ismiati Herlina
553	Kalisa Maulinda	20	\N	kalisa.maulinda	$2y$12$KIkXCPyMnvZRS2bqnqdOCuJaUIG4hxP/5bExMj7arc0tfDNThEFX2	3502	87339431	P	Jakarta	2008-03-16	3175055603080002	Islam	RT 1/RW 2 Paguan .Baru Kec. Bener	Yoso Hardono	Imas Noeraini
558	Okta Nur Arifa	20	\N	okta.arifa	$2y$12$KPIfpiffzV2RGAq/A0Azbe1pkj3qsmdXcHT18tG0femeTQScq5GP.	3507	77907640	P	Purworejo	2007-10-07	3306064710070001	Islam	RT 1/RW 7 Kenyaen 2 Semawung Kec. Purworejo	Robani	Lilawati
563	Sheril Alivia Ramadhani	20	\N	sheril.ramadhani	$2y$12$CIFhcI6B0mAVP7oL8fTy..i5C1ZhJKPXbSLtgYbimgtwLtRggiR5G	3512	79766676	P	Purworejo	2007-10-11	3306065110070003	Islam	RT 3/RW 8  BALEDONO Kec. Purworejo	Chairil Ismanto	Supriasih
568	Aprilia Fida Irmawati	17	\N	aprilia.irmawati	$2y$12$RXs/3fxLawEWTp5JjkekD.u8.zuHeNJtRzK8KO6HaQrdUnvFI3o9C	3373	81713160	P	Purworejo	2008-04-19	3306065904080003	Islam	RT 1/RW 6 Gunung Buthak pacekelan Kec. Purworejo	Ngadirin	Umi Habibah
573	Desy Rizki Faizah	17	\N	desy.faizah	$2y$12$jOIpAK3JUwv1k00.IkGIu.dhBDMVyF3UGmhrKAXc5dAUZ2T1UT9SG	3378	75744776	P	Purworejo	2007-12-03	3306044312070001	Islam	RT 1/RW 1 Bugel Desa/Kel. Bugel Kec. Bagelen	Puryanto	Chotimah
579	Fiyona Rahma Dewi	17	\N	fiyona.dewi	$2y$12$/MHvBr4nNmAEFTaAjdO5U.QSnruHuPYvxB10hw2xlcVzmkEzC0CNy	3385	82368947	P	Purworejo	2008-07-27	3306046707080001	Islam	RT 2/RW 4 Semagung Wetan Semagung  Kec. Bagelen	Triyono	Fitri Dwi Hartati
584	Nabilla Ardhiningrum	17	\N	nabilla.ardhiningrum	$2y$12$tYMmoeAi9bFLqSS6Hl/AP.4vnVLNT//N.WErF0Inj75.FI1o17s.e	3390	82932319	P	Purworejo	2008-04-02	3306064204080001	Islam	RT 3/RW 1 Krajan I Desa/Kel. Wonotulus Kec. Purworejo	Bambang Premadi	Rasinem
597	Shifa Aisiyah	17	\N	shifa.aisiyah	$2y$12$hpjxQ6qWGxg8m4/wEIE5Pewgr0lsEMtMOQO/b0FuLh6Rtyqniq6MG	3403	73035371	P	Purworejo	2007-10-22	3306056210070001	Islam	RT 4/RW 3 Sawahan Somongari Kec. Kaligesing	Parman	Sugiyati Suparto
602	Alfbia Vanesya	18	\N	alfbia.vanesya	$2y$12$tgYWR9IDf3JwTsp.P5s2Ku2CumTB7XAcQboHgBRO1./ZIGOJ42.VW	3408	85260148	P	Purworejo	2008-07-21	3306046107080001	Islam	RT 3/RW 2 Sijo Semono Kec. Bagelen	Ngadiman	Sunarti
605	Anik Lestari	18	\N	anik.lestari	$2y$12$RV1M3WLcfV0bZBY3NTag3OU33V803UFLROE0vM59D0Nst0i0uajiG	3411	81142293	P	Purworejo	2008-08-17	3306045708080001	Islam	RT 4/RW 3 Ketitan Sokoagung Kec. Bagelen	Sumiran	Yatiyas
609	Auliya Febiyanto	18	\N	auliya.febiyanto	$2y$12$eQOWpy6O5RomOr04cEAHxe/y4L1cyZHgjFjcOsCFYIdLtsJWy1c96	3415	87611078	P	Purworejo	2008-02-01	3306064102080003	Islam	RT 5/RW 2 Sligen Ganggeng Kec. Purworejo	Suyanto	Umi Siswati
614	Della Puspitasari	18	\N	della.puspitasari	$2y$12$wuR9nTMe6luxpYB9wEFu3eTigSAR5ssPq2ETduyf6XVxA/nAUEUCq	3420	85753076	P	Purworejo	2008-04-26	3306046604080001	Islam	RT 1/RW 2 Sangkalan Bapangsari Kec. Bagelen	Bambang Sugiyanto	Isma'Rifah
473	Eliya Masliha	10	\N	eliya.masliha	$2y$12$7hqV1Eym3EJPEwy.2PrQtO3ponWa9ZxmhtDaVZIzi0KkW4DLJ9drO	3592	91938787	P	Purworejo	2009-09-10	3306065009090001	Islam	RT 3/RW 8 Krajan Wetan Pacekelan Kec. Purworejo	Fauzi	Supriyana
478	Mario Adi Prasetyo	10	\N	mario.prasetyo	$2y$12$QnouD8362GFRaAvW3dD7Zeogy8c9JYmGJJDciXI7bN1/TocXCiPqS	3597	81399614	L	Purworejo	2008-11-04	3306060411080001	Islam	RT 5/RW 9  Baledono Kec. Purworejo	Dedi Kurniawan	Sri Puji Astuti
483	Najwa Zelvia Zahra	10	\N	najwa.zahra	$2y$12$pgDayRxkv835CpVBceUQfedjKm7i.pLzBteQSEdFYRBZjnulsKfkS	3602	94561831	P	Purworejo	2009-07-14	3306055407090001	Islam	RT 1/RW 3 Sawahan Somongari Kec. Kaligesing	Sudarmono	Yuliani
489	Slamet Eko Aprilianto	10	\N	slamet.aprilianto	$2y$12$hl3oLtsfelUt5zuCJTKscOPyGSExJ.Z7V3IQ2q.UWSLyzGTY1kKX.	3609	97370795	L	Purworejo	2009-04-17	3306041704090002	Islam	RT 7/RW 1 Keposong Desa/Kel. Krendetan Kec. Bagelen	Joko Purnomo	Sunarsih
494	Yanuar Stya Nugroho	10	\N	yanuar.nugroho	$2y$12$cN6WRKPsjxMryBf5uinC7uiXOV.xQJgSRsdBRIvJZ3GHIFSpgi.CO	3614	93970345	L	Purworejo	2009-01-19	3306071901090001	Islam	RT 3/RW 3 Galindu Boro Kulon Kec. Banyu Urip	Sri Lestari	Sri Lestari
620	Kurnia Mutia Sari	18	\N	kurnia.sari	$2y$12$EV2cOJ2I/xTY/kxU5zgpJ.hyEuUnJyKnCA9QHHMMsRomQ4LRmYAN6	3426	89942292	P	Wonosobo	2008-06-25	3307026501080001	Islam	RT 2/RW 2 Gadingan Desa/Kel. Gadingrejo Kec. Kepil	Suwasno	Muntaiyah
622	Lisvia Arindia Fani	18	\N	lisvia.fani	$2y$12$QXa7RSwas5cBpd3kqKBb5etLmpNfG5Ij8lTIu9rXODDiWrFyGf.kW	3428	79250254	P	Purworejo	2007-08-11	3306065108070001	Islam	RT 2/RW 8 Kalitambak SIDOMULYO Kec. Purworejo	Haryanto	Wantiyem
625	Merlina Victoria	18	\N	merlina.victoria	$2y$12$zE65GD83Oxluw4p.rTNUM.cWj2MmFxGEJQb9dP9ckgakjOxXynfou	3431	83725794	P	Purworejo	2008-03-31	3306047103080002	Islam	RT 9/RW 2 Dermosari 02 Durensari Kec. Bagelen	Sukijo	Lasmi
628	Nila Desiani	18	\N	nila.desiani	$2y$12$Xk7wt41bxvm0CyMlCCacze220kSOoAVl3xabO9NwQCCcIWRAW8wWG	3434	76309622	P	Purworejo	2007-12-17	3306065712070006	Islam	RT 3/RW 5  Desa/Kel. Tambakrejo Kec. Purworejo	Ujianto	Ina Dwiningsih
630	Ririn Alfianti	18	\N	ririn.alfianti	$2y$12$1wlR0Yt6u2QrvIFRb7lsS.U6Ne4AqFtjxP9ia3vC8FdZznrCBoT3e	3436	75072348	P	Purworejo	2007-01-11	3306065101070001	Islam	RT 1/RW 1 Semawung Semawung Kec. Purworejo	Agus Karijanto	Narti
632	Siti Nur Hidayah	18	\N	siti.hidayah	$2y$12$STtddLWgcwfqR96FUyiIBe04yuI0kMcY120jUOkeEhEZiqyQPuE6K	3438	74897901	P	Purworejo	2007-05-09	3306054905070003	Islam	RT 6/RW 1 Krajan somongari Kec. Kaligesing	Muhamad Efendi	Sumini
635	Vera Lucyana Aryani	18	\N	vera.aryani	$2y$12$yfFPWkuLEGf6vp73y2zEbepFXYnQzXmMq33OQk1SHTU7d1zrZp3Au	3441	82087909	P	Purworejo	2008-05-11	3306045105080001	Islam	RT 4/RW 2 Sangkalan Bapangsari Kec. Bagelen	Sardi	Maryani
638	Amin Saras Pujiono	15	\N	amin.pujiono	$2y$12$SGiw8Yscq8F0ANIxJslQ1eGH5z5tlYjHGjXoI/trditFdExIRmI92	3300	88053374	L	Purworejo	2008-04-17	3306041704080001	Islam	RT 1/RW 2 Krajan Kidul Piji Kec. Bagelen	Suwarto	Asih
640	Arif Fahthurrahman	15	\N	arif.fahthurrahman	$2y$12$D1VxnPpJh/VbeTXsEoraYuu5DHzulwk9rXL9PN5g0joakJJw3DvP6	3302	85819273	L	Purworejo	2008-03-05	3306030503080003	Islam	RT 4/RW 4 Bangun Desa/Kel. Keduren Kec. Purwodadi	Paidi	Yuniarti
643	Casey Gilang Praditia	15	\N	casey.praditia	$2y$12$fxzHJcxEpm0KELO2KHfoOeADK0RrSbLZMgDU/sACmgW3SG0AFKYd2	3305	89085167	L	Purworejo	2008-07-25	3306062507080002	Islam	RT 2/RW 4  Desa/Kel. Kedung Sari Kec. Purworejo	Irwanto	Rini Noviani
645	Dandi Hikami	15	\N	dandi.hikami	$2y$12$ynf2yH9V0oSXBFGfYtk0jeBJviqka8FPLxepXZf/n8eYDSUQsPwpO	3307	88909363	L	Purworejo	2008-08-05	3306080508080003	Islam	RT 1/RW 5 Bambon Desa/Kel. Sambeng Kec. Bayan	Ujang Jayusman	Juwariyah
648	Eko Erlangga	15	\N	eko.erlangga	$2y$12$mF498b2vKE7Fnax6W0DhIO3ChYeTIXgtLVcRlaOhKs1v7ScJNO0R6	3310	77432911	L	Purworejo	2007-08-31	3306043108070001	Budha	RT 2/RW 2 Sekangun Sokoagung Kec. Bagelen	Tusirin	Windarti
650	Eryawan Dwi Santoso	15	\N	eryawan.santoso	$2y$12$5hIOa2bvaqeXQnDBVE7ISeSemP/jxQXuRv436g6yp1KE08S9vOOSu	3312	58829418	L	Purworejo	2005-10-02	3306060210050002	Islam	RT 2/RW 6 Kenyaen I Semawung Kec. Purworejo	Joko Santoso	Saridah
653	Giega Muchamad Razief	15	\N	giega.razief	$2y$12$elXbDZ20bm2oKjVCEvrzm.8UVa3WmKUjpjfEdejwsq4dN9SA/u.o6	3315	71180361	L	Purworejo	2007-12-11	3306061112070002	Islam	RT 2/RW 2 Ngawang-Awang Desa/Kel. Brenggong Kec. Purworejo	Arokhman	Jumiati
655	Kezan Aurellio	15	\N	kezan.aurellio	$2y$12$Ob9jIMJdmTVufb8a9G3U9eqzURF.9qdcGoyTtDL05jl4sNkM2Ef5K	3317	84147370	L	Purworejo	2008-07-12	3306061207080001	Islam	RT 4/RW 1 Donorati Donorati Kec. Purworejo	Danang Swandi Kartiko	Susanti
658	Muhammad Sa'Id Fatih Romadhon	15	\N	muhammad.romadhon	$2y$12$Pp57/BZJbxgfoner9MVaXeERMArYN/rGhI0RbD0TSDPOQvnol8gGW	3320	73236447	L	Purworejo	2007-09-24	3306062409070002	Islam	RT 1/RW 1 Karang Pencil Wonoroto Kec. Purworejo	Subagiyo	Sumarni
661	Prima Hari Widodo	15	\N	prima.widodo	$2y$12$nufnIO/cBAew.VOaJ/fswOVi.lklBQWxITMIxsoHVCTeTLWzU9PHy	3323	78376790	L	Jakarta	2007-11-10	3306041011070002	Islam	RT 2/RW 2 Krajan Wetan Kemanukan Kec. Bagelen	Budi Hartono	Tri Suntari
663	Raihan Zainul Mutaqin	15	\N	raihan.mutaqin	$2y$12$aZ3TSA1L4gz/TYDSvmnrGuikaGLT//O38.wSedNcTS0xADmt8dvfy	3325	76722452	L	Purworejo	2007-05-09	3306070905070004	Islam	RT 2/RW 2 Borotawang Boro Wetan Kec. Banyu Urip	Heri Sugiyanto	Fepri Apsari
666	Ridho Haridono	15	\N	ridho.haridono	$2y$12$Af.Oz2ni8PWRCwSstdNp5O.DGHLPKyeVWiG0FQ6lsIwkyN/cPWZ8O	3328	87894072	L	Purworejo	2008-10-04	3306030410080001	Islam	RT 2/RW 1 Dusun Kalangan Bongkot Kec. Purwodadi	Suharto	Ngatini
668	Sahrul Fajar Erlangga	15	\N	sahrul.erlangga	$2y$12$EKKMMGY/d35mFMcHLOb47.GPbouBHythVgIwI087S42W6wGXeKdNG	3330	89513511	L	Purworejo	2008-05-06	3306060605080002	Islam	RT 1/RW 2 Semawung Semawung Kec. Purworejo	Hari Fitriadi	Suranti
671	Vanan Dwinata Prasetyo	15	\N	vanan.prasetyo	$2y$12$o3.sscfMQ9/PSjldighRfeNk4.aRLAvgql4nzj078YG9vqkxjsDH.	3333	75686119	L	Purworejo	2007-08-05	3306060508070002	Islam	RT 8/RW 6  Baledono Kec. Purworejo	Mulyono	Sudarmisih
676	Ahmad Rifai	16	\N	ahmad.rifai	$2y$12$TWUTP5ya0dKNoWHH3lJloeaCKVMQFn5/UON2fZqqki3TRjhkA1iIW	3338	87080410	L	Purworejo	2008-07-08	3306060807080003	Islam	RT 0/RW 0  - Kec. Bagelen		Sri Mulyani
681	Arif Widodo	16	\N	arif.widodo	$2y$12$popBlwT38rZuuPmJHwq87uBavq/A4ROWbvGoDWqMkacHVpTD4iP56	3343	86658244	L	Purworejo	2008-03-11	3306051103080003	Islam	RT 12/RW 3 Sigayang Jatirejo Kec. Kaligesing	Saekan	Tukirah
686	Danang Prastyo Aji	16	\N	danang.aji	$2y$12$1UBWSUEwbQqNA6CeoG.DbOTXOmPuvxEzV/3LbWt/Fx5Lt6r6ouRLK	3348	88270779	L	Purworejo	2008-09-24	3306042409080001	Islam	RT 4/RW 3 Pakuran Desa/Kel. Bagelen Kec. Bagelen	Puji Santoso	Daryati
691	Gunawan Adhi Wijaya	16	\N	gunawan.wijaya	$2y$12$roUBd9oLE759ORFG4SapjO4TL.UKw53knmfm2UEaKa23RDFxKSzoG	3353	146242371	L	Purworejo	2008-08-08	3306060808080003	Islam	RT 2/RW 7 Rukem Sidomulyo Kec. Purworejo	Susanto	Istiyani
693	Irfan Mubaroq	16	\N	irfan.mubaroq	$2y$12$LP4pcGvQjlvFS6Zc5CQlWOCUvFAyM/qSWwPmHCNPeCZ87d/w/Ab2O	3355	89820629	L	Purworejo	2008-02-17	3306061702080001	Islam	RT 4/RW 7 Semawung Semawung Kec. Purworejo	Suwadi	Parlina
697	Raffi Zainul Mutaqin	16	\N	raffi.mutaqin	$2y$12$YS.xXzwwYGPp4eWE0FmV7.P/6AjzaMIDE/ErbX9sTWWD2RB4cceaS	3359	74393486	L	Purworejo	2007-05-09	3306070905070001	Islam	RT 2/RW 2 Borotawang Boro Wetan Kec. Banyu Urip	Heri Sugiyanto	Fepri Apsari
702	Salsabilla Khairun Nissa	16	\N	salsabilla.nissa	$2y$12$QOOAdYezKq8c7pXigvcZ7eaj9DVaOx5LNpdhRzK7DT8.zMDEYB2QO	3364	83436822	P	Purworejo	2008-07-12	3306065207080001	Islam	RT 3/RW 1 Kemantren Semawung Kec. Purworejo	Abudaya	Henny Kuswandari
495	Abidzar Khansa Raihan	19	\N	abidzar.raihan	$2y$12$h55rRyetkeD7ORBKdUiRteTa/GORooonU1YZ5cefNzkBJjTSDU5/K	3444	82783568	L	Semarang	2008-07-13	3306121307080001	Islam	RT 5/RW 1 Cangkrep Lor Cangkrep Lor Kec. Purworejo	Kurniyanto	Lis Handayani
496	Adelia Nabila Chakim	19	\N	adelia.chakim	$2y$12$4bZf.ddVqLiUFxxe3zxvYexBLXBXbkI0EgJf99DPvexlC5gG0d7Tu	3445	74315816	P	Pemalang	2007-12-22	3327126212070001	Islam	RT 1/RW 5 Ngandul Jenar Wetan Kec. Purwodadi	Lukman Chakim	Wartiningsih
497	Afiifah Dwi Oktaviani	19	\N	afiifah.oktaviani	$2y$12$6CUIlqzw/..U8Ov0jOrEdOeBoAO45Q2VonlRsDNkSqLNdCNaRxx7O	3446	78401415	P	Purworejo	2007-10-27	3306066710070001	Islam	RT 3/RW 15 Plaosan Baledono Kec. Purworejo	Pardiyanto	Kuswaningsih
499	Arina Ni'Matuzzakiah	19	\N	arina.nimatuzzakiah	$2y$12$7nNLTrLQZQufNZ.z67JRv.nY7lvmSzlt0FElhujkIJAlBM7JQRkg.	3448	89045098	P	Purworejo	2008-02-13	3306045302080001	Islam	RT 13/RW 4 Durenombo Durensari Kec. Bagelen	Rasno	Noviana Ariani
500	Arini Nasywa Salshabila	19	\N	arini.salshabila	$2y$12$Q8woPSxYWMDRBfQQu9Bvo.1adog/b4rhDF2drjBBW2GqfwoU92AU6	3449	82202468	P	Purworejo	2008-06-08	3306044806080002	Islam	RT 5/RW 2 Kuwojo Dadirejo Kec. Bagelen	Wuwuh Hartono	Suminah
503	Cindy Dwi Andany	19	\N	cindy.andany	$2y$12$HunMbZBhwaE55eLBpcPXHuE3jjsvh686rONiUZkM.PL45RKqDxpXa	3452	82982056	P	Purworejo	2008-01-18	3306065801080001	Islam	RT 6/RW 1 Cangkreplor Cangkrep Lor Kec. Purworejo	Karnam	Eny Supriyati
504	Dea Nur Pratitis	19	\N	dea.pratitis	$2y$12$olreUJ0yZp03nqq9o4Fwnu1LxUuK075hklMcG8FhSMJFX1RBtMmii	3453	71802393	P	Purworejo	2007-06-14	3306055406070001	Islam	RT 3/RW 3 Denansri Donorejo Kec. Kaligesing	Sakir	Sutinem
506	Dila Aulia Puspaningrum	19	\N	dila.puspaningrum	$2y$12$eSoTcHlcOLBR3ai1cNhiMu4wqGKnlKRdQZPrOcAFoz6L9IlCFXNXG	3455	86741786	P	Purworejo	2008-01-18	3306065801080005	Islam	RT 2/RW 2 Patebon DADIREJO Kec. Margorejo	Jasuki	Resmi Setyawati
509	Ferlyta Dwi Hapsari	19	\N	ferlyta.hapsari	$2y$12$dhZsir3lRUylAu5776kLLOTLBy0/gm4AXECX0AcOiiFc4EDBkuORy	3458	84630203	P	Purworejo	2008-06-02	3306064206080002	Islam	RT 2/RW 2 Jogoresan Ganggeng Kec. Purworejo	Hariyanto	Supriyani
510	Fiani Wilujeng Raharjanti	19	\N	fiani.raharjanti	$2y$12$fPDYqhwW4ElqiSMx/gnHYOVggsemfd29CZ.qBSVumzekBfRzzvz3a	3459	87715215	P	Purworejo	2008-03-31	3306047103080001	Islam	RT 1/RW 7 Bojong Desa/Kel. Bapangsari Kec. Bagelen	Heru Sunarto	Tuti Hidayati
514	Isna Laisya Yulianti	19	\N	isna.yulianti	$2y$12$E3654Sbp77EhbcnSHG86xe5G.q8BwkF2o0YejRwcLez3krYNj..x.	3463	74730445	P	Bogor	2007-04-16	3276085604070001	Islam	RT 4/RW 2 Sidamukti SUKAMAJU Kec. Kaligesing	Gerard Yunius Hadi Nugroho	Warsiyah
517	Lufki Tri Astuti	19	\N	lufki.astuti	$2y$12$sKr7SfdyGFkQAHASjFRB0.DCFUW2tphMmaXU4HX1fubsJ8uFXrPMq	3466	77274180	P	Purworejo	2007-11-02	3306034211070001	Islam	RT 2/RW 2 Sikepan SUMBERSARI Kec. Purwodadi	Sunarso	Parningsih
519	Medina Ayu Rahma	19	\N	medina.rahma	$2y$12$7cBa/SgVwvWGGwo1.JJ.leI6Vw0By9B6hCnlkvpRbU8jf/T81TAy2	3468	81734580	P	Purworejo	2008-05-25	3306036505080001	Islam	RT 3/RW 5 Ngandul Desa/Kel. Jenar Wetan Kec. Purwodadi	Suprapto	Naniek Setyorini
520	Muharromah Tri Handayani	19	\N	muharromah.handayani	$2y$12$IzxHtyteiy3HXaEbR1CgmuHwH1YLEA4XZo2iQuOjeacZ2RG52QvfO	3469	83411336	P	Purworejo	2008-01-27	3306046701080001	Islam	RT 1/RW 3 Gatep Desa/Kel. Bagelen Kec. Bagelen	Sugiharso	Pardiyah
523	Oktavia Rahmadani	19	\N	oktavia.rahmadani	$2y$12$cCifhSb6QUv06nieZuwmzuvYJQiPZG9XuqL/FV6KoQD9hH/NOEaJG	3472	71551962	P	Purworejo	2007-10-01	3306054110070002	Islam	RT 1/RW 3 Tegowano Tlogorejo Kec. Kaligesing	Waluyo	Wantiyem
524	Syafiatun Eka Nur Rukmana	19	\N	syafiatun.rukmana	$2y$12$cy9uXGfU5Q9XldmbDwR0hesP0/t8BDX22THeGN48KDks3Z.okVmie	3473	82797588	P	Purworejo	2008-03-11	3306045103080001	Islam	RT 3/RW 4 Kebokuning 1 Desa/Kel. Soko Kec. Bagelen	Saifuddin Yuhri	Suyanti
526	Tegar Rukmana Saleh	19	\N	tegar.saleh	$2y$12$Y0kcyHbTvRywnOySTi20Zusbvc.aE48/VrXOuyMuM2MSJeEfLGsvC	3475	79744340	L	Purworejo	2007-05-23	3306062305070007	Islam	RT 4/RW 1 Jombangan Ganggeng Kec. Purworejo	Dwi Sriyanto	Sutarmi
528	Winda Auliandari	19	\N	winda.auliandari	$2y$12$SkozypIPLPouPUm07CeXmuFjkQdxfC1P9a06t3FW2NYK6lshOSmaa	3477	81283440	P	Purworejo	2008-04-04	3306044404080001	Islam	RT 5/RW 1 Kaliagung Sokoagung Kec. Bagelen	Sumari	Sumirah
529	Yuliana Eka Saputri	19	\N	yuliana.saputri	$2y$12$Rzf/DOtdWRlaG5xs8huvleSirHu0gtF/BR7ibw7yfeaQFQAeG4Mu.	3478	71798496	P	Purworejo	2007-07-18	3306055807070001	Islam	RT 3/RW 4 Jeruk Purut Desa/Kel. Kaliharjo Kec. Kaligesing		Ramiyati
530	Yulianita	19	\N	yulianita	$2y$12$7hnxp1Vk8ikEWuEnVcxQ6u/rB7XPkkt0rQbJGvAJ75SVc2v7bMffu	3479	87124006	P	Purworejo	2008-07-03	3306034307080002	Islam	RT 1/RW 1 Dusun Krajan Desa/Kel. Jatikontal Kec. Purwodadi	Suwarjo	Suci
533	Arla Shafa Fauzyah	20	\N	arla.fauzyah	$2y$12$49mcmBWasSArT5RWyz8DHOboCELiIshmINvF3cdqa65c5DUIvzyDq	3482	88687085	P	Purworejo	2008-06-28	3306066806080003	Islam	RT 1/RW 6 Makemdowo Desa/Kel. Sido Mulyo Kec. Purworejo	Yono	Nanung Marlina
535	Aulia Rahma	20	\N	aulia.rahma	$2y$12$T5wFU99WQJTlG3fAD1ld1OvzMCbBv79fCbI3FrEdoZk2zocgNmfh.	3484	97885301	P	Purworejo	2009-07-07	3306064707090002	Islam	RT 1/RW 1 Krajan Desa/Kel. Cangkrep Kidul Kec. Purworejo	Karyo Utomo	Triyani
536	Azizah Zulfaa Rahma Pratiwi	20	\N	azizah.pratiwi	$2y$12$9PUY7ozh4IsiDYSIVKQSGecGHc4kOikiV0PmdScxr97cfI1WS7cDm	3485	87514708	P	Purworejo	2008-09-23	3306056309080001	Islam	RT 1/RW 1 Desa Kidul Pacekelan Kec. Purworejo	Prayitno	Diyah Kariyani
539	Dania Anjani	20	\N	dania.anjani	$2y$12$RVsFWJjgRWnto.13Fgxo5ueJPtjhYfFxDAQ/emUfv1ZjAogs6qVJ6	3488	82280303	P	Purworejo	2008-01-18	3306045801080004	Islam	RT 5/RW 1 Kaliagung Desa/Kel. Sokoagung Kec. Bagelen	Jamil	Suryani
540	Dendy Adi Nugraha	20	\N	dendy.nugraha	$2y$12$BMK32KIayl.vTbIi6TSFu.saTp7LEx8WMcDRr4pc/NwE8RvlYJPv.	3489	75536797	L	Purworejo	2007-12-17	3306061712070001	Islam	RT 2/RW 2 Manggisan Cangkrep Lor Kec. Purworejo	Sudarto	Enggar Handiani
542	Eka Ardelia Fitriyani	20	\N	eka.fitriyani	$2y$12$OkQjMdrm/cqbnA/TOpmAru8ZN5lL8hR7njjRFZUfq63saMtq2nL6a	3491	89942364	P	Purworejo	2008-10-04	3306084410080002	Islam	RT 1/RW 4 Manisjangan Sido Mulyo Kec. Purworejo	Muchamad Muhyidin Arofingi	Waginem
545	Eka Septiyani	20	\N	eka.septiyani	$2y$12$X6BsGDiEl1X5SIX2q4ZP8OqHlCxTyGk7jG4eGw.xjFZI7wA7sbmfG	3494	76124851	P	Purworejo	2008-09-29	3306046909080001	Islam	RT 1/RW 1 Kaliagung Desa/Kel. Sokoagung Kec. Bagelen	Tupan	Kuatminingsih
546	Eni Yuliani	20	\N	eni.yuliani	$2y$12$JivgSRo3ApMmdP5X.y9yM.t63CEbRoLIfoBBFnmbtb.nwP.qBwloa	3495	67981732	P	Purworejo	2006-07-28	3306046807060001	Islam	RT 1/RW 2 Krajan Wetan Kemanukan Kec. Bagelen	Ponidi	Apriyani
549	Hasna Mahardika	20	\N	hasna.mahardika	$2y$12$VXFgWPm3XRpNQVhl74gtZuwf4TR5T211AZ9G/QAGNcnGWXtvdfEsC	3498	73831746	P	Purworejo	2007-08-16	3306045608070002	Islam	RT 2/RW 4 Soko Desa/Kel. Soko Kec. Bagelen	Sujiman	Nur Komariyah
550	Icha Varencia	20	\N	icha.varencia	$2y$12$mkHoys7WItAQ1iuvxAIUpe3fEOSz5YEq2rJXyAJw0mdeku5XX20L6	3499	86138162	P	Purworejo	2008-02-20	3306056002080001	Islam	RT 6/RW 1 Katerban Donorejo Kec. Kaligesing	Purwanto	Tina Rosmala Dewi
552	Kaira Falya Zivanjani	20	\N	kaira.zivanjani	$2y$12$U090NdiWRYAjTeRIND0USOFMa7mHlUDRHGNlZDFt5c4KjMfAAEPKy	3501	85088814	P	Jakarta	2008-01-25	3172026501080006	Islam	RT 6/RW 1 Cangkrep Lor Cangkrep Lor Kec. Purworejo	Margiyanto	Endang Kurniasih
555	Livia Raya Firnanda	20	\N	livia.firnanda	$2y$12$dhROuGOPDBgK6/vhrfKjQORBOBQkWNT4Qe7Mx4HTUsSVYtf8DLom2	3504	82657687	P	Tangerang	2008-08-12	3276025208080007	Islam	RT 1/RW 3 Kibon Piji Kec. Bagelen	Samijan	Suratmi
556	Mayla Aminingrum	20	\N	mayla.aminingrum	$2y$12$6P6TdEktNOFucbFeyyyq0OSnuCbnl/8cYrojVoIcIrgMwwVOu5MUC	3505	89993723	P	Ngawi	2008-05-27	3521186705080001	Islam	RT 5/RW 6 Bulu Ii Randusongo Kec. Gerih	Aminan	Mamik Robiyaningsih
559	Rama Bintang Adi Pamungkas	20	\N	rama.pamungkas	$2y$12$n92qZvuqq/sDzVUtNHYeC.REjNggZ7YqP4i854uF18.ItbnQhONdS	3508	89575294	L	Purworejo	2008-07-23	3306062307080003	Islam	RT 3/RW 7 Rukem Desa/Kel. Sido Mulyo Kec. Purworejo	Triyono	Nunuk Sri Rahayu
560	Reynata Dwi Setyoningsih	20	\N	reynata.setyoningsih	$2y$12$JgLdpOJ6XmwhpfAJSlKJFuzsVmW6nFqVOlJwE2kNjJELg4.sY82Qu	3509	72468790	P	Purworejo	2007-02-07	3306064702070002	Islam	RT 2/RW 4 Cocolan Pacekelan Kec. Purworejo	Ponimin	Tukinah
562	Seza Afrisagita	20	\N	seza.afrisagita	$2y$12$DqKvco7xMO/OmmxdmlUXgOKkq7KpUvFPyZOPhz2lsQGu07K.QrrTK	3511	85668829	P	Purworejo	2008-07-11	3306065107080001	Islam	RT 2/RW 1  Kedungsari Kec. Purworejo	Slamet Sugito	Sudarwati
565	Vicco Nalla Darossa	20	\N	vicco.darossa	$2y$12$TIqEYDJCa8iJqyFx65pzzenyCE.irtkEqIfXDiOOmvWk2jzTJJ8QW	3514	71623618	L	Purworejo	2007-10-19	3306061910070001	Islam	RT 4/RW 1 Krajan Wonoroto Kec. Purworejo	Sugiyono	Lilis Kurniati
566	Zaskia Indah Juniarti	20	\N	zaskia.juniarti	$2y$12$M5EVmQCEhS9lAJVHnR.pDeE5jJaANrbz2M7ImvDBy4W02som.2jRi	3515	85683817	P	Purworejo	2008-06-16	3306065606080001	Islam	RT 4/RW 1 Krajan Ii Wonotulus Kec. Purworejo	Aji Irawan	Urip Febriwati
569	Aqil Madya Atmaja	17	\N	aqil.atmaja	$2y$12$CwWiODTiRBaB/4nB8Q6hWeT43si.w3agV2a1yrLbk79bZIDA/P36m	3374	83868241	L	Purworejo	2008-04-16	3306061604080001	Islam	RT 2/RW 1 Dukuh Lor Desa/Kel. Sido Mulyo Kec. Purworejo	Madya Uji Suharso	Catur Murni
571	Bekti Indah Isnaini	17	\N	bekti.isnaini	$2y$12$QPt1q801voLnUto10z33gOVcxtbKkeG9xbzLXrmqpAI9mQtIp6eLi	3376	81246566	P	Purworejo	2008-08-24	3306046408080001	Islam	RT 2/RW 7 Pucungan Desa/Kel. Bapangsari Kec. Bagelen	Sujani	Titik Sudarsih
572	Cahaya Putri Hani	17	\N	cahaya.hani	$2y$12$tGKikq9EkeNMhKU5rfWtv.t1YGthD5101EkteiO4D14m/UfeKdN/q	3377	81181035	P	Jambi	2008-01-17	1571025701080001	Islam	RT 1/RW 2 Plipir Tengah Desa/Kel. Plipir Kec. Purworejo	Haryono	Yeni Mariyanti
576	Echa Tri Sanjaya	17	\N	echa.sanjaya	$2y$12$VCZk4UqXHLFKziR0SWVi6O6aZ/Cu82mRHafLvKEM04MVQ35.Txbeu	3381	84909505	P	Purworejo	2008-02-21	3306066102080001	Islam	RT 3/RW 1 Krajan Desa/Kel. Wonoroto Kec. Purworejo	Parno	Sopiyah
577	Edy Baskoro	17	\N	edy.baskoro	$2y$12$1OOgi98YgTcazyuy8N2lrOOjfs.mLqKhGnEwRoBnsO.nocJ04Bjjq	3382	86301089	L	Purworejo	2008-02-19	3306061902080002	Islam	RT 2/RW 1  Wonotulus Kec. Purworejo	Sunaryo	Poniyem
580	Gunarti Fiji Astuti	17	\N	gunarti.astuti	$2y$12$pwwiJxkL.3xweZFEMbYhoOLM6/WiQLMV9zwRtefNpJmumrKRrv12m	3386	76881879	P	Purworejo	2007-11-12	3306055211070001	Islam	RT 4/RW 4 Sijanur Desa/Kel. Somongari Kec. Kaligesing	Kemijan Purwanto	Suharti
581	Intan Suci Wulandari	17	\N	intan.wulandari	$2y$12$2dTOKJ3WOxM4WH4BQiqff.nnfV5Iri5x0eaiTJgsuN2iFwuHg4SLW	3387	73058591	P	Purworejo	2007-12-04	3306044412070002	Islam	RT 3/RW 1 Karang Jambu Desa/Kel. Dadirejo Kec. Bagelen	Sanyo	Siti Sumiyati
583	Lutfika Nur Azizah	17	\N	lutfika.azizah	$2y$12$Yz9cxPsnz51Debsma.MgM.Vii/w1b9o1tSqz1MyjgmUM2KFCvYvgW	3389	83553347	P	Purworejo	2008-02-11	3306065102080003	Islam	RT 1/RW 2 Kembaran Semawung Kec. Purworejo	Sri Mulyani	Sri Mulyani
586	Putri Agustina	17	\N	putri.agustina	$2y$12$6.FE5UKLdPtlqqd6AKUE8eqx.HdyRFKG0KbjP..QA.GuLb.IPpLGa	3392	72262568	P	Purworejo	2007-08-04	3306064408070001	Islam	RT 3/RW 3 Mudal Desa/Kel. Mudal Kec. Purworejo	Mujiyanto	Warsi
587	Putri Dian Anggraini	17	\N	putri.anggraini	$2y$12$e7i3ZywugfZIbY3lOJukme0ZdPiL13.mBrfJa.5rPplbOVqtLgqYq	3393	72319985	P	Purworejo	2007-09-14	3306045409070001	Islam	RT 1/RW 8 Kalimaro Desa/Kel. Bapangsari Kec. Bagelen	Tugiyono	Sulasih
589	Ratih Kusuma Ningrum	17	\N	ratih.ningrum	$2y$12$h2jIpUKnKh.NGzMjzcrRq.P8yExdZUU4tsU.V69e.SlzzhgirroaW	3395	89404876	P	Purworejo	2008-04-09	3306064904080002	Islam	RT 2/RW 2 Krajan Cangkrep Kidul Kec. Purworejo	Pur Supriyo Harjono	Kadarningsih
591	Risma Kinanti	17	\N	risma.kinanti	$2y$12$Ssz5DXNxZg9ArL8jLUwPN.g/ZCnEzrD0DsH0bynU0K4rnx.0TuJY.	3397	61868474	P	Purworejo	2006-05-03	3306064305060006	Islam	RT 4/RW 7 Jatisalam Semawung Kec. Purworejo	Rakhmat Basuki	Suryati
592	Rizka Oktaviani	17	\N	rizka.oktaviani	$2y$12$j6QxVpcT9t3/OPWlOgLkfO2AyNRqofujZhs3jA.k8IVeaivPbjhwm	3398	72897005	P	Purworejo	2007-10-18	3306055810070003	Islam	RT 3/RW 2 Klepu Pandanrejo Kec. Kaligesing	Untoro	Rukmini
594	Selly Febriana Elisei	17	\N	selly.elisei	$2y$12$9OBk3wk/6T0MVdfXDAbBLeFiGmQ76p7U1lUQr7doVa60mrGxOCYw6	3400	83648285	P	Purworejo	2008-02-18	3306085802080001	Islam	RT 6/RW 2 Secang Lor Sucenjuru Tengah Kec. Bayan	Ari Setiawan	Umi Haryanti
595	Shafa Nadhira Khansa	17	\N	shafa.khansa	$2y$12$u2sb04oRuHGzcFFkFFkSluWivCc2h3WmvlOiJJcLtwLyJhuViWyhS	3401	87966091	P	Purworejo	2008-02-26	3306066602080001	Islam	RT 1/RW 1 Desa Kidul Pacekelan Kec. Purworejo	Sulistyo	Pintaryati
598	Tintia Aura Shafila	17	\N	tintia.shafila	$2y$12$HvnofZyHRe07.nFH2IskCuvsMZ/UhREYLKK49HH8TWG8.T9qqckoG	3404	73823381	P	Purworejo	2007-07-19	3306045907070002	Islam	RT 1/RW 4 Ngargo Desa/Kel. Hargorojo Kec. Bagelen	Junaidi	Ratini
600	Wahyu Nur Rohman	17	\N	wahyu.rohman	$2y$12$iPrPGxMPI1kHnA492CYxkObFcetIdses1EkpoWtBT59lIwp9.y3TG	3406	81385112	L	Purworejo	2008-03-21	3306042103080001	Islam	RT 8/RW 3 Kedungrejo Desa/Kel. Sokoagung Kec. Bagelen	Sarbino	Rubini
601	Widhi Jalmanto	17	\N	widhi.jalmanto	$2y$12$NL4z3OYh.ESR/djm7Wub9uJ4D705RFrm5d87iiJ/w0YVmXGCZeQYa	3407	73883275	L	Purworejo	2007-09-09	3306050909070001	Islam	RT 9/RW 2 Krajan Desa/Kel. Jatirejo Kec. Kaligesing	Slamet Waluyo	Musri
604	Amelia Anggraeni	18	\N	amelia.anggraeni	$2y$12$3qvGau2wVcCh53uqFY0ZjedvKKTIkAqyNC24lrqMpcq2SR.KSQV4S	3410	63207698	P	Garut	2006-08-02	3205304208060002	Islam	RT 4/RW 1  Wonoroto Kec. Cikelet	Bambang Suherman	Tati Nurhayati
606	Arifah Zainina Gunawan	18	\N	arifah.gunawan	$2y$12$72yPuDPneK5r.fJ43x4XquqWrX.t3qB.wtiuDjb4ab7di/Uo7QcCe	3412	78266532	P	Bogor	2008-10-16	3201045610080005	Islam	RT 1/RW 5 Sidomulyo Sidomulyo Kec. Sukaraja	Agni Gunawan	Barijah
607	Arista Nur Septiani	18	\N	arista.septiani	$2y$12$IkxBrxNuJjmqRIN.pZzHWOTQ0RlisAlW9gn95Ix2UPfyV4jdgw3um	3413	73328646	P	Purworejo	2007-09-03	3306064309070001	Islam	RT 1/RW 3 Kretek Pacekelan Kec. Purworejo	Adi Sumaryo	Anis Sulatifah
610	Azizah Auliasari	18	\N	azizah.auliasari	$2y$12$N.b0Pq5M8ze5AeZTLCnZw.QAKedsBIoHnsASg215mz98L.2sA.DXa	3416	94909162	P	Purworejo	2009-01-23	3306046301090004	Islam	RT 3/RW 5 Tepus Desa/Kel. Somorejo Kec. Bagelen	Suryanto	Sujirah
611	Bunga Amalia Wibawantari	18	\N	bunga.wibawantari	$2y$12$S77g04/BXh6zFI8OU2QPLOrPDSOFPkPY2yanjxwCjqW2wcPtRuyZy	3417	76843331	P	Purworejo	2007-08-30	3306057008070002	Islam	RT 3/RW 4 Gogoluas Desa/Kel. Tlogoguwo Kec. Kaligesing	Juwarno	Ponirah
613	Danang Prasetyo	18	\N	danang.prasetyo	$2y$12$vhfjD0bEldrrw5JGBmOADufHQAp6M7lKLZ/Q8MSzy/hD.dgiGCyFq	3419	71457400	L	Purworejo	2007-09-29	3306052909070004	Islam	RT 1/RW 3 Sawahan Somongari Kec. Kaligesing	Sugiyanto	Ngadirah
616	Divanda Ayu Lestari	18	\N	divanda.lestari	$2y$12$kQF/kvzofKC4RwIdOMPpJulyOqIrbha5PkqCL95q/4pnMM5sKUJ9e	3422	86964556	P	Purworejo	2008-01-14	3306065401080001	Islam	RT 2/RW 1 Desa Kidul Pacekelan Kec. Purworejo	Ngadino	Tibah Lestari
617	Fadhilah Ramadhan	18	\N	fadhilah.ramadhan	$2y$12$48wk.pFT6ex/RVW90OwU5.E8dX58SaUUqCR1tpgLbiKMMi.X8MZM2	3423	73777057	L	Purworejo	2007-09-25	3306062509070001	Islam	RT 2/RW 1  Tambakrejo Kec. Purworejo	Trimo	Siti Kotimah
619	Kholifatul Fatimah	18	\N	kholifatul.fatimah	$2y$12$8KYJLSC6JmsKgR476SI/7eNITiqCGFsxo9cGb74IkBOAN6LMlGrz2	3425	84803276	P	Purworejo	2008-02-15	3306045502080001	Islam	RT 5/RW 3 Ketitan Desa/Kel. Sokoagung Kec. Bagelen	Roman Siamin	Turiyem
623	Meita Priyanti	18	\N	meita.priyanti	$2y$12$o8ANsyLozJNmeF.sX6/gqusa0XpfsY3kC2xzzSA1Cq/6idovMlK.i	3429	81861872	P	Purworejo	2008-05-21	3306046105080001	Islam	RT 3/RW 1 Keposong Desa/Kel. Krendetan Kec. Bagelen	Supriyadi	Poniyati
627	Muthia Utami Fauziah	18	\N	muthia.fauziah	$2y$12$k0VylaRkaJHHjrnhF3NlgORxKT2rvQs/lZ6YlPE3GntbR8pqA6sgq	3433	78133908	P	Purworejo	2007-12-11	3306045112070001	Islam	RT 2/RW 3 Karangsari Kemanukan Kec. Bagelen	Bardi	Yatinem
629	Queen Rieke Wardani	18	\N	queen.wardani	$2y$12$5tmkcNLBMqSQbTkoFxtWled9kNnSilRtdQSnFTPBjw1ucv/.Xx0BC	3435	88621166	P	Bekasi	2008-10-13	3216075310080005	Islam	RT 3/RW 3 Karangjati Desa/Kel. Krendetan Kec. Bagelen	Yadi Supriyadi	Wardaningsih
634	Suci Wening Sayekti	18	\N	suci.sayekti	$2y$12$5NjX0wDOXTmdIBxGEmIAIeRamXretPuAZruD/0t4Wq7Ch.SxBLsby	3440	88719960	P	Purworejo	2008-06-21	3306056106080001	Islam	RT 2/RW 4 Kedungrante Desa/Kel. Kaligono Kec. Kaligesing	Wagino	Tri Marsini
636	Vrisca Yenny Issabella	18	\N	vrisca.issabella	$2y$12$tWImdp9sP5.MYYoP9a1YBO.iS9qUq9UmsOtZhUzVXKHHs/DhnD3Ra	3442	79970225	P	Purworejo	2007-07-31	3306067107070002	Islam	RT 2/RW 2 Cocolan Pacekelan Kec. Purworejo	Wahab Istoko	Tuminah Isnaini
637	Widya Utami	18	\N	widya.utami	$2y$12$JOQxSzJI7QsHU8bsEb6VkOd2wcClTZP6qadLBIQRnaUC4ZucNWe.i	3443	79678416	P	Purbalingga	2007-12-25	3303046512070001	Islam	RT 1/RW 6 Legok Cangkrep Kidul Kec. Purworejo	Jumadi	Sumaryanti
641	Arlita Muthmainnah	15	\N	arlita.muthmainnah	$2y$12$PD5PLVxtNn4xGy/DtrGeCeC/2vzEhO3.ZQgl.mMl41j5KIPTStic2	3303	86083814	P	Purworejo	2008-05-28	3306046805080001	Islam	RT 3/RW 1 Krajan Desa/Kel. Tlogokotes Kec. Bagelen	Sardji	Dwi Susiani
644	Damarjati Alfin Riyanto	15	\N	damarjati.riyanto	$2y$12$dMmh3LYd.lJX.yjkshM88eW1xJ6U1JV57M0LTW925/zDf077kFS3.	3306	93352521	L	Demak	2009-05-08	3321130805090001	Islam	RT 2/RW 2 Sudimoro Sudimoro Kec. Purworejo	Pawit Riyanto	Suklimah
647	Dwi Febrianto	15	\N	dwi.febrianto	$2y$12$gTGJK/dC1N7LcZjF.OuOF.2nm9E3RmozzRuRVPzX6abh2zo1DZdJ6	3309	82766948	L	Purworejo	2008-01-28	3306042801080001	Islam	RT 4/RW 1 Krajan Lor Piji Kec. Bagelen	Sugiyanto	Marniyem
651	Fahri Husaeni	15	\N	fahri.husaeni	$2y$12$ICsCeZJWBwtdCbOx82hcpOn166X2ZYK.pylI7zulR5/QomQUFON6C	3313	82878962	L	Purworejo	2008-02-17	3306071702080001	Islam	RT 1/RW 2 Ploso Desa/Kel. Tegalrejo Kec. Banyu Urip	Istadi	Sunarti
654	Jatmiko Nafi Hidayat	15	\N	jatmiko.hidayat	$2y$12$IYMymHd/9gXjsUeMcYN93egKCNLXWHJgtKMsyZDryyun9xUQKgfze	3316	85159208	L	Purworejo	2008-01-05	3306060501080001	Islam	RT 2/RW 2 Cangkrep Lor Desa/Kel. Cangkrep Lor Kec. Purworejo	Tofik Hidayat	Winnarti
657	Muhammad Hisbullah Al Anshari	15	\N	muhammad.anshari	$2y$12$fhu3viEAMQrtoVX5tXFkqOQNWwShwSa9y68VJBGb99gevSV.aD/ri	3319	77774813	L	Purworejo	2007-08-05	3306060508070001	Islam	RT 2/RW 1 Krajan Paduroso Kec. Purworejo	Budi Santoso	Woro Astuti
660	Pandu Raja	15	\N	pandu.raja	$2y$12$q.yw6oxWPncWQXWLL5/wOOTineiLl5nhGqr2xcbQgneoBwBM0kj0u	3322	56628890	L	Purworejo	2005-09-16	3277021609050006	Kristen	RT 1/RW 2 Sekangun Sokoagung Kec. Bagelen	Yunita Nugrohadi	Rita Prihatini
664	Reni Handayani	15	\N	reni.handayani	$2y$12$lcCVgHEP66a3JpNcKMM5HO0BlQ84jZ2WFXr5yw0lbS7QGLFyCb9lS	3326	88629556	P	Purworejo	2008-05-09	3306044905080001	Islam	RT 5/RW 1 Keposong Desa/Kel. Kalirejo Kec. Bagelen	Surono	Warliah
667	Rizky Aditya Santosa	15	\N	rizky.santosa	$2y$12$/vkbvNSfwwP3cwGZF5pJd.ZZ1KZJIkHF1/9koQNTJ5GWzkqYOuk/m	3329	86013713	L	Purworejo	2008-01-08	3306040801080001	Islam	RT 2/RW 7 Bojong Desa/Kel. Bapangsari Kec. Bagelen	Budi Santosa	Erlis Tami Maryati
670	Syahzid Dharma Riezki	15	\N	syahzid.riezki	$2y$12$zNNgOgeJ7NtOoqxET2til.bBMT81atIgcQcklczxcs/8u/h/bJYAi	3332	71563925	L	Cianjur	2007-11-01	3203070111070001	Islam	RT 1/RW 2 Krajandua Kaliurip Kec. Kemiri	Edwin Darmansyah	Wagiyah
673	Wisnu Himawan	15	\N	wisnu.himawan	$2y$12$4EEkiA/CSsAosm9/kv0bwedacHZPOE0aPA8X3GsvRHA4PjQgq5Tdq	3335	71764018	L	Purworejo	2007-10-19	3306061910070003	Islam	RT 2/RW 2 Panggulan Donorati Kec. Purworejo	Amat Sulaiman	Nuning Riyanti
675	Agus Suparjianto	16	\N	agus.suparjianto	$2y$12$nOjJ0QMOjUYu4hs4/RJ1..bGQbe5qDsYiaa0g5rwsbS7MN1vyqWcO	3337	53659117	L	Purworejo	2005-08-18	3306051808050002	Islam	RT 2/RW 4  Tlogoguwo Kec. Kaligesing	Parino Muji Raharjo	Mursini
678	Alif Ariffian Fatul Ulla	16	\N	alif.ulla	$2y$12$ZC/RWPoDK7OtDI0/YF29kewiAQowLuMCIS00x5EzVRK9dRI0OBy9u	3340	86277678	L	Purworejo	2008-05-28	3306152805080001	Islam	RT 1/RW 3 Situmbu Kalinongko Kec. Loano	Tri Andriyanto	Budiyati
679	Andicka Vicka Nur Pratama	16	\N	andicka.pratama	$2y$12$sTpRxvl3JQxtsaIRkj7VkONJsNQoIRevaF35jfRQqIc..scW1Sl7G	3341	82700857	L	Purworejo	2008-07-08	3306060807080004	Islam	RT 5/RW 2 Panggulan Donorati Kec. Purworejo	Vitalis Setianang	Sukarjilah
682	Ashfi Warraihan	16	\N	ashfi.warraihan	$2y$12$1EJ/4UnRLT6NwA0GfD6N7.qBsuKUf61lT5YNR9YPyyzcj8hnRBhm.	3344	89517520	L	Purworejo	2008-10-28	3306032810080001	Islam	RT 2/RW 2 Ketangi Desa/Kel. Ketangi Kec. Purwodadi	Dwi Saptadi	Ngamilah
684	Aulia Wianda Herlanie	16	\N	aulia.herlanie	$2y$12$sw.NriP0WDPzwFpFzAvZBuUAhrA.Xrg/pbnI/QiBdeNs0tZbEK4VW	3346	77694655	P	Purworejo	2007-06-30	3306067006070002	Islam	RT 3/RW 1  Semawung Kec. Purworejo	Kuat Widianto	Siti Nurfaida Minarti
685	Dafa Andika Pratama	16	\N	dafa.pratama	$2y$12$nPkOoj4.4inTj4aeeewY1eN3wfqNSzleIrE.GLW80G8OPQLrkRgse	3347	87371471	L	Purworejo	2008-07-03	3306060307080003	Islam	RT 1/RW 1 Jambul Brenggong Kec. Purworejo	Puji Handoko	Saimah
688	Fahrizal Prasetyo	16	\N	fahrizal.prasetyo	$2y$12$0oU8ZeqsSSVMizaPWP3h5uDF7QqfjTn.QFLXgbkUOR7qtggtYSWaW	3350	79609089	L	Purworejo	2007-12-16	3306071612070001	Islam	RT 2/RW 5 Popongan Popongan Kec. Banyu Urip	Setyo Wahono	Muntinah
689	Fery Priyanto	16	\N	fery.priyanto	$2y$12$0TOS63XBb7W5ha1GvjWf/OGDdQM4wlzRtBNJk3TdOxhDhzqor2Jc6	3351	87576614	L	Purworejo	2008-02-12	3306041202080001	Islam	RT 4/RW 1 Krajan Lor Piji Kec. Bagelen	Triyono	Fitriyati
692	Intan Maharani	16	\N	intan.maharani	$2y$12$XCSwXMrFGKwgpwhThcg5FOGcci/T5UQKwe89tdWlDFB63tSb534ma	3354	88700754	P	Purworejo	2008-07-03	3306044307080001	Islam	RT 4/RW 1 Krajan Desa/Kel. Tlogokotes Kec. Bagelen	Purwanto	Tri Suryati
694	Muhammad Nabil Faiz Rasif	16	\N	muhammad.rasif	$2y$12$A1TQH53lYJyBZ2zhTV7oQegy.pllnkkEkwC.A.0sGZwB3an.A3mbu	3356	66594763	L	Purworejo	2007-04-23	3306062304070006	Islam	RT 3/RW 4  KESENENG Kec. Purworejo	Karsono Teguh	Lia Wahyu Dwi Mulyani
695	Muhammad Rafi Dhiya-Ulhaq	16	\N	muhammad.dhiyaulhaq	$2y$12$oTQDt6fvg3N/ZYbX.aIAg.oxsu8gn1an6d8q6EADIMDdWmyZVxB/2	3357	77395914	L	Purworejo	2007-12-26	3306062612070002	Islam	RT 3/RW 5  Tambakrejo Kec. Purworejo	Cahyo Andriyanto	Heni Setia Budiningsih
696	Muhammad Zain Fuady	16	\N	muhammad.fuady	$2y$12$2CYAhSPXVQg4m8h1SPEVx.F.BZcI2gdVb.BNzRbmBbQcx7.K65fzi	3358	88428807	L	Purworejo	2008-04-25	3306062504080001	Islam	RT 1/RW 1  Desa/Kel. Ganggeng Kec. Purworejo	Amit	Menik Sunarmi
699	Rayhan Annas	16	\N	rayhan.annas	$2y$12$aBaIvyjUkbhOYbM9DADyeuyoCA2Wtw5NEUWckQQpHca8kWBFWJ.mG	3361	78295217	L	Purworejo	2009-03-06	3306040603090002	Islam	RT 2/RW 2 Bugel Desa/Kel. Bugel Kec. Bagelen	Fatchudilatif	Marsini
700	Riva Fadil	16	\N	riva.fadil	$2y$12$jQlEDiW6OXq/23VWR/upjeL6qVe9DveOkouYmt51m3k3tfEQ0g7lC	3362	85547027	L	Purworejo	2008-01-10	3306031001080003	Islam	RT 1/RW 2  Desa/Kel. Sidoharjo Kec. Purwodadi	Mangaji	Siti Adirotus Solihah
703	Satria Chandra Wijaya	16	\N	satria.wijaya	$2y$12$E.EYOXijo8j7u6Pzw9T6nObjrzvlARwMytMUIwEJpVl3/3hHUMT1m	3365	89547189	L	Purworejo	2008-04-04	3306050404080003	Islam	RT 6/RW 2 Krajan Desa/Kel. Jatirejo Kec. Kaligesing	Patman	Mukholidatun
705	Sukur Mukhafidin	16	\N	sukur.mukhafidin	$2y$12$SQeERuTOskPCYzDnZmvr5ekfQmS9q6A0rbAv1P79aeDouHTvkcJmq	3367	89760748	L	Purworejo	2008-07-18	3306061807080001	Islam	RT 2/RW 4  Tambakrejo Kec. Purworejo	Sajidin	Fatoyah
707	Ulil Amri Setiaji	16	\N	ulil.setiaji	$2y$12$jmJz8XdWktMKNOAQdDfbVu/CpSp8RJLHpgiYxsVpGJU4dacW6SLk6	3369	73920705	L	Purworejo	2007-12-19	3306061912070001	Islam	RT 4/RW 1 Bokongan Desa/Kel. Sidorejo Kec. Purworejo	Supriyatno	Andrianajati Setyaningrum
708	Yoghi Imam Syaputra	16	\N	yoghi.syaputra	$2y$12$X2wVVB1onuEearIlFDv8peKbKFjJFcyw83S/ydo9M6GkOlY0L/Uq6	3370	84519957	L	Purworejo	2008-03-02	3306050203080001	Islam	RT 13/RW 3 Sigayang Jatirejo Kec. Kaligesing	Giyanto	Ngatini
397	Abigail Khalil Maulana Achmad	8	\N	abigail.achmad	$2y$12$iDKH.Zc9cASNW.q1ubHMMuwrOMujZyvp7MiD1YYLU3LvT3KLHt212	3516	99383932	L	Jakarta	2009-05-29	3175082905091002	Islam	RT 1/RW 4 Perumahan Griya Sejahtera Tambak Block D3 Desa/Kel. Tambakrejo Kec. Purworejo	Achmad Elyasyah	Wahyuni Tri Purwanti
398	Aditya Galang Pradita	8	\N	aditya.pradita	$2y$12$ULOHezREufbAe47PCYxpF.eNBDb.a2ywP1zUmSEZ35mnKrw7F.XKy	3517	88161071	L	Purworejo	2008-08-16	3306041608080002	Islam	RT 3/RW 3 Karang Sari Kemanukan Kec. Bagelen	Mahni Suyoto	Mustika Umiyati
400	Daffa Fadhlur Rohman	8	\N	daffa.rohman	$2y$12$dgTspAW6IPQuU8WUKCOwkOEoOtpqL1ZHBBeUp4gLAg/2thUczsDqq	3519	97027622	L	Purworejo	2009-02-21	3306062102090002	Islam	RT 3/RW 2 Sudimoro Desa/Kel. Sudimoro Kec. Purworejo	Sarino	Puji Astuti
401	Darelleo Veda Alana	8	\N	darelleo.alana	$2y$12$PDZVqgvrIIx/PHrzbbn.E.6K6thlA6xEo1xCJUXPZchpYrKjDc0VO	3520	95355179	L	Purworejo	2009-08-18	3306061808090002	Islam	RT 3/RW 1 Krajan Wonoroto Kec. Purworejo	Suraji	Turini
404	Eva Octavia	8	\N	eva.octavia	$2y$12$mh61uthOJYFSAlPAUuXZcu8t0AzJzJUKd1Wlavjskdgk7JHf75oXC	3523	88955937	P	Purworejo	2008-10-17	3306065710080003	Islam	RT 3/RW 2 Keseneng Desa/Kel. Keseneng Kec. Purworejo	Aspan	Maesaroh
405	Fajar Nur Fauzan	8	\N	fajar.fauzan	$2y$12$rZ8O313ifiRNUQfCDT1TJOrvPNKdszzIN4SoQIDm6l0rI/603IEVC	3524	3085883602	L	Purworejo	2008-12-13	3306061312080001	Islam	RT /RW  Cangkreplor Desa/Kel. Cangkrep Lor Kec. Purworejo	Edy Wardoyo	Sri Wahyuni
408	Farkhan Hidayat	8	\N	farkhan.hidayat	$2y$12$mWJM/iszuHGBoReebhd1MuLj3MZLVuo6hePO.dmNkNDzggT25eVyC	3527	93110702	L	Purworejo	2009-07-10	3306061007090001	Islam	RT 4/RW 2  Desa/Kel. Kedung Sari Kec. Purworejo	Sahadi	Sri Hartini
412	Keisa Rahmawati	8	\N	keisa.rahmawati	$2y$12$2VnAN07G9qSBfeS97tMGieWfHY3kB4tE7JJnLh3JRkQ.hoZJachfy	3531	87312104	P	Purworejo	2008-07-31	3306067107080002	Islam	RT 2/RW 1 Donorati Donorati Kec. Purworejo	Pardiman	Kisrowiyah
413	Keyla Shiva Az Zahra	8	\N	keyla.zahra	$2y$12$i1Z8YBAqIB51dEqNILyXz.AdT50kFF5XKL4iDex1vlplaYU8hwtdK	3532	91627684	P	Purworejo	2009-07-23	3306036307090001	Islam	RT 1/RW 2  Desa/Kel. Sidoharjo Kec. Purwodadi	Sukarman	Euis Maemunah
416	Muhammad Jallu Arif Prasetyo	8	\N	muhammad.prasetyo	$2y$12$1yOsCimfGs2a7ptFR483r.zzQul9Ue7DaTjOXfuB6c7dJVqoXIB4S	3535	92037421	L	Pati	2009-07-22	3318032207090001	Islam	RT 2/RW 2  Desa/Kel. Wonotulus Kec. Purworejo	Arif Budiman	Suhartini
418	Nafalsa Setyawan	8	\N	nafalsa.setyawan	$2y$12$qpKiepyPgMGiU5QcRN1DCO2F/Z8ZLCTZRt0ElLAdWUTYppabVINBm	3537	89919986	L	Purworejo	2008-09-21	3306062109080002	Islam	RT 4/RW 8  Baledono Kec. Purworejo	Makmur Santoso	Fatimah
419	Novita Fajar Ramadhani	8	\N	novita.ramadhani	$2y$12$wyhPC4Qdu8cohyI2OD1ROumBXYJeFRtgQcsVKcpXdFV9eWhBosDEm	3538	85736806	P	Purworejo	2008-09-23	3306156309080003	Islam	RT 1/RW 6 Dusun Tegal Desa/Kel. Jetis Kec. Loano	Fajar Dwi Isro'I	Siti Muntamah
420	Restu Prasetya	8	\N	restu.prasetya	$2y$12$sv.o3LBKZJGn4hTLqY3Mz.ZX93K7vCJE/cZJybCJZ0jhc9fbD673e	3539	92755746	L	Purworejo	2009-05-29	3306062905090001	Islam	RT 1/RW 1 Krajan I Wonotulus Kec. Purworejo	Pratitno	Semirah
421	Restu Sulistyo Putra	8	\N	restu.putra	$2y$12$zy2b8srUCCXje98RFjYrqetHhO0yRFIIhmsO1urv9MK5a73uMJuMG	3540	85141993	L	Purworejo	2008-11-15	3306061511080002	Islam	RT 3/RW 1 Krajan 1 Gintungkerta Kec. Klari	Listya Mulyana	Dwi Supartiyati Ningsih
422	Susanto Jaya	8	\N	susanto.jaya	$2y$12$5Npobwui5rKg7GuQYRo49uP60BVewp7tLiphYsjHdDKu11xJNGwSq	3541	95559051	L	Purworejo	2009-09-18	3306041809090002	Islam	RT 1/RW 3 Tlogo Desa/Kel. Tlogokotes Kec. Bagelen	Jumono	Dede Triyana
423	Tasyahara Putri Aryanda	8	\N	tasyahara.aryanda	$2y$12$Ex2AmMxHEqt536fXjjdfG.fXOjaOFsnZ.Wn3HKulVfMDLofk9ADmy	3542	97263521	P	Purworejo	2009-09-13	3306075309090001	Islam	RT 3/RW 3 Jurangan Boro Kulon Kec. Banyu Urip	Taryan	Ida Suramaryati
424	Tiara Andjani Putri	8	\N	tiara.putri	$2y$12$O/VySJKg0csV4L1gHDiFZeVKSHck7nEy9h3L0dxWoRbi/HUWgScC6	3543	98285826	P	Purworejo	2009-01-23	3306066301090001	Islam	RT 6/RW 4 Baledono Desa/Kel. Baledono Kec. Purworejo	Marsidi	Wawat Watisah
425	Wisetya Aqila Febrian	8	\N	wisetya.febrian	$2y$12$ki.4P22pRgzMSWt9QND7FeCkg4TzusYgCRWmYLyVQfQ69ABLcsi1W	3544	96744641	L	Purworejo	2009-02-10	3306141002090001	Islam	RT 3/RW 1 Krajan Keseneng Kec. Purworejo	Iwan Setyawan	Indah Wijayanti
426	Yanuar Dwi Setiawan	8	\N	yanuar.setiawan	$2y$12$Hc4Z7TaM.36exJNA/1YVt.5KadzVyS6kZzDKIpp1EuA0TNjddaWUG	3545	92226290	L	Purworejo	2009-01-08	3306070801090001	Islam	RT 4/RW 7 Kenyaen Ii Semawung Kec. Purworejo	Tekat	Dewi Susilowati
427	Zhafran Lingga Prathama	8	\N	zhafran.prathama	$2y$12$X0Th39wPALYGftFsnDolauAJu9QxKvGTcL2BR01liI7.DvQHBFU1q	3546	97597883	L	Purworejo	2009-11-17	3306041711090002	Islam	RT 2/RW 3 Kedung Menjangan Desa/Kel. Bagelen Kec. Bagelen	Sunardi	Suyanti
428	Zidan Fadhila Alfaiz	8	\N	zidan.alfaiz	$2y$12$ZBbiB6QLde5UeMvD8poU/OdVCRMdQIY3t6PXNRNcNacFByBu/PSmq	3547	97425434	L	Purworejo	2009-09-06	3306060609090003	Islam	RT 1/RW 3 Karangrejo Desa/Kel. Paduroso Kec. Purworejo	Muchamad Umar Fauzi	Retno Arumsasi
429	Zuhrul Anam	8	\N	zuhrul.anam	$2y$12$2U572Btq0zyvf.KE2z8TJ.wUeXVT5bE3EcfUb76otz9zifoYVnWd6	3548	95458943	L	Purworejo	2009-06-07	3306070706090001	Islam	RT 3/RW 1 Karangsari Boro Kulon Kec. Banyu Urip	Imam Makmuri	Sugiarti
430	Adelia Listy Nugraha	9	\N	adelia.nugraha	$2y$12$fyb9bSdd4QRH5Of5kgwsUuwaWF0MpQe4ee2Au4oWacExcLytNXkGy	3549	97646023	P	Tangerang	2009-04-14	3674045404090003	Islam	RT 6/RW 4  Sawah Kec. Ciputat	Priswanto	Anisa Listiyani
431	Ahmad Nafi' Junaidi	9	\N	ahmad.junaidi	$2y$12$.LRER7GXK2XyENZsbsif7OlZ4tFOEJr0lv8wSw.U8/bFbvBjTmtg6	3550	99521067	L	Purworejo	2009-06-27	3306062706090001	Islam	RT 1/RW 1 Tambakrejo Desa/Kel. Tambakrejo Kec. Purworejo	Suprapto	Siti Rohmah
432	Ahmad Syabban Zakiyyan	9	\N	ahmad.zakiyyan	$2y$12$Y5oPQ.h8qIq8/c/sgNVXy.oCONUZv0ryU/aO1yqT991iVq5Z8enTa	3551	89143217	L	Purworejo	2008-12-27	3306082712080003	Islam	RT 1/RW 3 Jeketro Kaligono Kec. Kaligesing	Aidy Rialyah Sugiarto	Siti Chotijah
433	Alhafit Evan Ramdani	9	\N	alhafit.ramdani	$2y$12$Fhq8CV8eyNlwfNuyrVsETetoTMt8NjTtJNsW5fKp93HGtfGXdlYu2	3552	94743114	L	Purworejo	2009-08-27	3306072708090001	Islam	RT 2/RW 2 Borotawang Boro Wetan Kec. Banyu Urip	Suwardi	Kamsidah
434	Anandita Vega	9	\N	anandita.vega	$2y$12$Rmx/zUJF2NMBS21OaKOy3eywrWVBvQdaLbmAJoZPRcva3f9ncXR02	3553	83398104	P	Purworejo	2008-05-23	3306076305080001	Islam	RT 1/RW 1 Popongan Popongan Kec. Banyu Urip	Sigit Ngatmoko	Eni Susanti
435	Ardiansyah Suhartono	9	\N	ardiansyah.suhartono	$2y$12$yKz7h2RAghEd/ZjPtgOQm.r/gJliosVXJsJsGTenvboK6HONeA1zi	3554	94075312	L	Purworejo	2009-01-04	3306060401090002	Islam	RT 3/RW 2 Karang Mulyo Wonoroto Kec. Purworejo	Eko Budi Hartono	Sumilah
455	Raditya Dimas Maulana	9	\N	raditya.maulana	$2y$12$ASxs0iJTaPW/8z52RXApI.SXDqFkbZ9z8pZMHS9f6t8Xsf9tNFO.e	3574	95119764	L	Purworejo	2009-06-20	3306122006090001	Islam	RT 6/RW 4  Desa/Kel. Sidanegara Kec. Cilacap Tengah	Marsudi	Usriyah
457	Rian Ardiyanto	9	\N	rian.ardiyanto	$2y$12$Gd9jnzEHhcvlF5xYiMwOH.lW0cup61BrmzMjX5CxK2y3Pi4K4ivta	3576	74358092	L	Bandung	2007-12-07	3204050712070004	Islam	RT 1/RW 1 Krajan Kulon Kemanukan Kec. Bagelen	Tata Supriatna	Surati
458	Ridho Praditya Putra	9	\N	ridho.putra	$2y$12$b5uzKFGcIIRAeVJJcJKqwOeq3jSQjjt.YYlPGs/4yumhLsoHbQPfu	3577	93660508	L	Purworejo	2009-01-20	3306062001090001	Islam	RT 3/RW 1 Wonoroto Wonoroto Kec. Purworejo	Joko Sulistyo	Eka Wardani
461	Triyono	9	\N	triyono	$2y$12$aOf65MbySR3eWfV7tRw33edvlAwHu2IdQBsx0nK2tx/Jh905Kxiyq	3580	77759898	L	Purworejo	2007-06-23	3306052306070001	Islam	RT 0/RW 0 Sijanur Somongari Kec. Kaligesing	Sutarto	Ponijem
462	Wahyu Budi Prakoso	9	\N	wahyu.prakoso	$2y$12$m7nfMibBXVxh.PrIU3iMc.kYzFIlxMN5QNoz9bXlOQOfCrsUTmZ0q	3581	87605936	L	Purworejo	2008-04-21	3306042104080003	Islam	RT 2/RW 2 Kahuripan Desa/Kel. Kalirejo Kec. Bagelen	Awan Mujiono	Puji Rahayu
464	Ahmad Alfan Mubarok	10	\N	ahmad.mubarok	$2y$12$zAyTyoQ2E5/zznXRkMD4qunZnxP3QdiuakzbNASC2IbvPjxq560ee	3583	3082335049	L	Purworejo	2008-11-18	3306061811080003	Islam	RT 1/RW 1 Cangkrep Kidul Desa/Kel. Cangkrep Kidul Kec. Purworejo	Mohamad Zamroni	Rusmiyati
467	Ananda Anugrahnanto	10	\N	ananda.anugrahnanto	$2y$12$mzs947Zi6nSmIIvw1a3JI.HK9ATu7urFFAw3Kg3kDHQLkZwzlVnOm	3586	95163225	L	Purworejo	2009-02-17	3276051702090003	Kristen	RT 1/RW 4 Gambasan Desa/Kel. Jelok Kec. Kaligesing	Sudaryo	Darmini
468	Andian Ma'Ruf	10	\N	andian.maruf	$2y$12$pUO0AxW0ZkigbL22TiDjeuduD7DZRvKn5dsh6naK5V/4TdQn2EL66	3587	94454855	L	Purworejo	2009-03-08	3306050803090003	Islam	RT 0/RW 0 Sigayang Desa/Kel. Jatirejo Kec. Kaligesing	Subur Pambudi	Kustiati
472	Dinda Rahmawati	10	\N	dinda.rahmawati	$2y$12$OEyYBN46rgL6L7ItXsurEugNPO1kIpm1Z4Z/5P0ItGrbEkzciJ9MG	3591	95131220	P	Purworejo	2009-07-10	3306065007090002	Islam	RT 1/RW 2 Krajan Cangkrep Kidul Kec. Purworejo	Supriyadi	Wastinah
474	Galih Praditya Dwi Saputro	10	\N	galih.saputro	$2y$12$/nPL0bUZcFWjB50WQsS8MeZFJ1wduI2f05ZLIoOeX5EDnOL1BKGFK	3593	92353649	L	Purworejo	2009-06-16	3306031606090001	Islam	RT 4/RW 2 Pabrik Keduren Kec. Purwodadi	Warsito	Aprikisanti Rinti Pratiwi
475	Hendry Herlistyo	10	\N	hendry.herlistyo	$2y$12$0X53lYJLQLNxewby324y6OJKkheLYar2i3d5/1x4hbnRrLVD3RLJ2	3594	99048819	L	Purworejo	2009-01-23	3306142301090001	Islam	RT 3/RW 4 Kroyo Kidul Kroyo Kec. Gebang	Dwi Hermanto	Suliyati
479	Muhamad Hanif Saputra	10	\N	muhamad.saputra	$2y$12$vrsLRLii8Oqdngu1AyUJyuKHTGo6ovM0C1LjGhqwCFLnudHZjqYk2	3598	95878990	L	Purworejo	2009-08-18	3306121808090001	Islam	RT 3/RW 2 Ngasem Loning Kec. Kemiri	Abdul Chamid	Siti Rokhimah
480	Muhammad Abdulrahman	10	\N	muhammad.abdulrahman	$2y$12$1HUy8NrxbR7j4S9fQ4YT5O27VkrWMBDJ3agEue6h/Mz8elIgZwagG	3599	78957937	L	Purworejo	2007-08-31	3306063108070001	Islam	RT 1/RW 4 Mranti Mranti Kec. Purworejo	Amat Slamet	Sukini
482	Muhammad Farhan Zen Maulana	10	\N	muhammad.maulana1	$2y$12$BNyg2jo3MiZkI//P.ASSbOXBFb6BZVQ.1ajWzli04KJ9jFnLrEF6u	3601	92032088	L	Purworejo	2009-03-01	3306030103090001	Islam	RT 1/RW 2 Purwodadi PURWODADI Kec. Purwodadi	Wibowo	Dyah Woro Trimurti Ningrum
485	Natasya Raichana Putri	10	\N	natasya.putri	$2y$12$gPoIeHFlmG/UL/41k1kALOGdk54F7kkktda3qhxALKIzPOh54wm06	3604	85986148	P	Purworejo	2008-11-09	3306144911080001	Islam	RT 3/RW 2 Kalitengkek Kalitengkek Kec. Gebang	Khamid	Rina Rosdiyana
486	Revinja Isya Maulana	10	\N	revinja.maulana	$2y$12$DPqhU6DsopL9vx0yr..gWeifekVpj7t3H.XDWaK3xlYY4iEXy10JG	3606	81971076	L	Purworejo	2008-04-06	3306140604080001	Islam	RT 7/RW 3 Baledono Jagalan Baledono Kec. Purworejo	Ade Enjayanto	Puji Hariyanti
488	Setya Dharma Adi Nata	10	\N	setya.nata	$2y$12$HQ9t9TQ2hiNJQ11Pa0OVf.bh/dY81g/0.GteEaeWVtdrFt9QiLsAO	3608	86119061	L	Purworejo	2008-11-14	3306041411080002	Islam	RT 1/RW 4 Karangrejo Kemanukan Kec. Bagelen	Kustanto	Sudaryani
491	Suhgi Eka Ramdani	10	\N	suhgi.ramdani	$2y$12$F5TI/Biz9QUZjOo3A3yDkuGbwpVxVbVQWzDZoWHykx2LcNnV./TeK	3611	84130645	L	Purworejo	2008-10-24	3306042410080001	Islam	RT 3/RW 2 Sijo SEMONO Kec. Bagelen	Suhendar	Mugi  Setyaningsih
492	Wahyu Rohadi	10	\N	wahyu.rohadi	$2y$12$sx/6iG4nJ0vU.jorefsJaexLrgon4aWIyV914QUslVztlD9.LpNmW	3612	74836540	L	Purworejo	2007-09-23	3306042309070001	Islam	RT 1/RW 2 Krajan Kidul Piji Kec. Bagelen	Sartono	Waginem
328	Aprilia Setianingrum	11	\N	aprilia.setianingrum	$2y$12$0VB4lPMwqMyXPiSujoJlDubNeW.1rituc6Yg3YZ3vCfXCNaRdUlYu	3616	92667615	P	Purworejo	2009-04-17	3306065704090003	Islam	RT 2/RW 2 Krajan Kidul Piji Kec. Bagelen	Sugiyo	Toyibah
329	Arleta Dinda Kharisma	11	\N	arleta.kharisma	$2y$12$EQtNZy1VJ1NYCL5LzbzMO.Yt1BgK4QjJyr9RSSzv4.YglUfn0c1pu	3617	92080351	P	Purworejo	2009-05-03	3306064305090002	Islam	RT 1/RW 2 Droko Wonotulus Kec. Purworejo	Ari Ilyasak	Kharima
331	Dina Safitri	11	\N	dina.safitri	$2y$12$nDetDwBJggfD9c1vXUgzSeM8uUrQ3HCui.vA5hkNF2yZHetK/JPoa	3620	159939632	P	Purworejo	2008-12-07	3306024712080001	Islam	RT 1/RW 1  Desa/Kel. Jeruken Kec. Ngombol	Suyadi	Umoro Estri
332	Dini Wijayanti	11	\N	dini.wijayanti	$2y$12$PLi5tvmY0e7Je2p0M3DcEOQYnPC5PK6RkQfohD6Vnmi36830cwjG.	3621	83378198	P	Purworejo	2008-12-09	3306044912080001	Islam	RT 1/RW 2 Bedug Desa/Kel. Bagelen Kec. Bagelen	Suroso	Rusiyati
333	Erniyanti	11	\N	erniyanti	$2y$12$1aUp6ZmmTD3hLyvjdE0diuNBPmtiAJpxRwECWGymQR5BxvQRR2wIe	3623	92257369	P	Wonosobo	2009-09-15	3307025509090002	Islam	RT 1/RW 1 Krajan SEMONO Kec. Bagelen	Arif	Sutari
335	Febria Fatikha Nur'Aini	11	\N	febria.nuraini	$2y$12$K2WnvdDLmfMeJDegAnmL/envCP0SAd/9N1gzyIMTsucYzAHmTNRVK	3625	97308863	P	Purworejo	2009-02-12	3306065202090002	Islam	RT 1/RW 7 Karang Anyar Cangkrep Kidul Kec. Purworejo	Mardiono	Mutmainah
336	Gita Fairus Alimah	11	\N	gita.alimah	$2y$12$8I.kh7BF2IsfV8q1EMez8.6WCay/P7bxPvTpxM0wkHM.ViJf7tDAS	3626	95949127	P	Purworejo	2009-01-07	3306064701090002	Islam	RT 4/RW 2 Kedungsari Desa/Kel. Kedung Sari Kec. Purworejo	Sigit Widodo	Khotiah
338	Keira Najwa Firdausy	11	\N	keira.firdausy	$2y$12$56XSn5N8xDk6hmtTzkpnTev5GK4xRjDHYELuMvp36sOandLDiGgLK	3628	92038580	P	Purworejo	2009-03-16	3306045603090001	Islam	RT 2/RW 1 Bagelen Desa/Kel. Bagelen Kec. Bagelen	Slamet Triyanto	Hepna Palupi
340	Lutfiatul Qomariah	11	\N	lutfiatul.qomariah	$2y$12$ZjgyXXUnpeuP4a.EiwnB0uAa3ukkXCkeWpTyZ5g0v1FwgowXak.a6	3630	88517663	P	Purworejo	2008-12-24	3306046412080001	Islam	RT 5/RW 3 Kedungrejo Sokoagung Kec. Bagelen	Dayat	Tusini
342	Melani Wulan Sari	11	\N	melani.sari	$2y$12$jt8lUlri78EsTjNKZZfJjeFnbq9UER2XvGFhFheFgLR.eM1kOWdwG	3632	99293831	P	Purworejo	2009-05-19	3306065905090002	Islam	RT 4/RW 6 Cangkreplor Cangkrep Lor Kec. Purworejo	Sarpin	Jumilah
344	Nana Shela Andriyana	11	\N	nana.andriyana	$2y$12$/MdYDuGH6RgWGcblb9k9KOhBYLWfgWUL./03FYKJ/HmOMXLZnmLae	3634	91649773	P	Purworejo	2009-06-26	3306066606090001	Islam	RT 2/RW 1 Tambakrejo Desa/Kel. Tambakrejo Kec. Purworejo	Baryono	Tugini
347	Novita Syifa Cahyani	11	\N	novita.cahyani	$2y$12$CHJEghPFMlG811amhHWz4OeICzpEbYrCrnC9W4rlk.ax/juyvSHuO	3637	99052055	P	Purworejo	2009-01-22	3306066201090001	Islam	RT 2/RW 2 Droko Wonotulus Kec. Purworejo	Eko Prasetyo Wibowo	Eka Lestari
348	Oktaviana Puspitasari	11	\N	oktaviana.puspitasari	$2y$12$0TBfvcC8yquX3nplHKA15.nUCjzUmg4ncj3FI1GNLUJigBGDq74ue	3638	89043686	P	Purworejo	2008-10-17	3306065710080005	Islam	RT 2/RW 3 Ngabean Kedung Sari Kec. Purworejo	Misngat	Kasmilah
350	Putri Setyawan	11	\N	putri.setyawan	$2y$12$aysShwxKXXJQl21xpvntT.qzz0sGuf.GSSMLM25QpwbqLy7CCe.Pm	3640	97648717	P	Purworejo	2009-09-12	3306065209090001	Islam	RT 1/RW 4 Brenggong Desa/Kel. Brenggong Kec. Purworejo	Jayeng Setyawan	Nurul Hidayah
354	Septia Rahmadani	11	\N	septia.rahmadani	$2y$12$DVp5jFb17N8sAvIeLh8MROl5Cp32zHtktJ7iTZ24uDd4Zp0TjpeVG	3643	97273949	P	Purworejo	2009-09-10	3306065009090002	Islam	RT 1/RW 9 Kalitambak SIDOMULYO Kec. Purworejo	Tambur Poniran	Emayanti
355	Silvi Ahlam Afriani	11	\N	silvi.afriani	$2y$12$5W0eYd/8TmyogcFDbwloeeSyYQDS1AmJC/GdXJas7TwoQoJBBY2Lq	3644	92935751	P	Purworejo	2009-01-09	3306034901090001	Islam	RT 2/RW 1  Tegalaren Kec. Purwodadi	Wahyudi Budi Utomo	Sutiarni
358	Veronika Riskiana	11	\N	veronika.riskiana	$2y$12$wU6D0mdOA8VhhgjU4wxPtu/aJwovMNT5TYFrp8uWJBKpHdvw8zLwq	3647	84036316	P	Purworejo	2008-10-03	3306054310080002	Islam	RT 1/RW 5 Ngesong Desa/Kel. Jelok Kec. Kaligesing	Jumadi	Sukini
359	Vika Nurohmah	11	\N	vika.nurohmah	$2y$12$65w2i7Fvv3UyxNfe7f5eU.Rn3DrsALRXDohd46zRFqc45GfjuTPuu	3648	97911327	P	Bekasi	2009-07-25	3306046507090001	Islam	RT 1/RW 5 Tepus Desa/Kel. Somorejo Kec. Bagelen	Karyadi	Fitri Susilawati
362	Alfira Yuli Kartikasari	12	\N	alfira.kartikasari	$2y$12$h.ZhHj3vFyPG.6nJJyyJFuZTHGXvOhfXcvNEKYnCP65fbPJLXoFyS	3651	95081969	P	Purworejo	2009-07-22	3306066207090002	Islam	RT 1/RW 9 Kalitambak Desa/Kel. Sido Mulyo Kec. Purworejo	Budiman	Peni Haryani
364	Aulia Permata	12	\N	aulia.permata	$2y$12$NkH35.N3/rRG4NYXvQQnrOwttrmOcvHMX0P7./ESYn9u4pLnU6kLy	3653	82201694	P	Purworejo	2009-11-12	3306045211090002	Islam	RT 2/RW 5 Sembiur Desa/Kel. Bugel Kec. Bagelen	Sukarjo	Sunarti
365	Awalina Cahyati	12	\N	awalina.cahyati	$2y$12$HYotSajXIdoZRdtSb65oLumYvgOFoa6GvYdR.a1zZCOdvQpArgulu	3654	89416135	P	Purworejo	2008-12-31	3306167112080001	Islam	RT 1/RW 7 Jolodoro Desa/Kel. Guntur Kec. Bener	Nariyanto	Waluyo Rokhidin
368	Deca Ayu Fany Damayanti	12	\N	deca.damayanti	$2y$12$psN9guFA7txk71xRcK/j0OJfWeiPOkLT9v8CSLTYk448BTbHEX9aO	3657	82104713	P	Jakarta	2008-12-10	3172035012081004	Islam	RT 2/RW 4 Sarangan Desa/Kel. Krendetan Kec. Bagelen	Irkhamudin	Puji Riyanti
369	Dwi Puspita Sari	12	\N	dwi.sari	$2y$12$A0OZu.1gXve0SDvmcn7El.h3F5iWgc3.ceVNXgHsCW3LQUKrvEaPS	3658	82147425	P	Purworejo	2008-12-28	3306156812080001	Islam	RT 3/RW 7 Wonolalis Desa/Kel. Kedungpoh Kec. Loano	Rambat	Siti Fatimah
373	Heny Nur Aisyah	12	\N	heny.aisyah	$2y$12$TiZTWgTaXPouEBTvDRvHTeJ1Zfc2zsOwzdM2eeZtereAL6mgDGaNm	3662	84621292	P	Purworejo	2008-10-11	3306045110080001	Islam	RT 1/RW 8 Kalimaro Desa/Kel. Bapangsari Kec. Bagelen	Suparlan	Supriyami
374	Khoniatun Nisa	12	\N	khoniatun.nisa	$2y$12$SFMd1mM3RueHoTIu6EBMz.tyMewOhW3mSosKpqkmHUk9RLjb3idD2	3663	84940504	P	Purworejo	2008-11-12	3306055211080002	Islam	RT 3/RW 2 Krajan Desa/Kel. Kaliharjo Kec. Kaligesing	Fajar	Kartini
376	Nila Agustina	12	\N	nila.agustina	$2y$12$BWe5m2mfOagIeRnRZRbvne.GXmuFTVFGADHe5/wwUhGUYtr.lHcuy	3665	54449515	P	Purworejo	2005-08-26	3306046608050002	Islam	RT 1/RW 4 Karang Rejo Kemanukan Kec. Bagelen	Pardi	Paisem
379	Priati Mulandari	12	\N	priati.mulandari	$2y$12$euRSzLQJati5R5A66hY4DOvxGpV55CFPWMYtOQ5VFJXiYXK5fajkm	3669	94747714	P	Purworejo	2009-03-02	3306044203090002	Islam	RT 3/RW 2 Sekangun Desa/Kel. Sokoagung Kec. Bagelen	Kemiso	Legisem
380	Reny Tulistiyani	12	\N	reny.tulistiyani	$2y$12$ssw0rwdKXLXqWbQorK.IN.2jAzBS3pnt6LZuCv0YXrCeEYjz4/2y6	3670	82277855	P	Purworejo	2008-07-05	3306044507080002	Islam	RT 1/RW 5 Jolotundo Kemanukan Kec. Bagelen	Tukijan	Tri Istriyanti
383	Riska Darma Febriana	12	\N	riska.febriana	$2y$12$ahNLaL4kzSlO5cjAOItxFOSxLEey4NoQYby7gm99UQ2LGr87bDTaW	3673	75738641	P	Purworejo	2009-02-22	3306056202090001	Islam	RT 3/RW 1 Joho Desa/Kel. Bapangsari Kec. Bagelen	Heri Iswanto	Sulistri
386	Sarinadatun	12	\N	sarinadatun	$2y$12$E54rTCt5nIJm1do0pIqSgu5XtFcrIupddtNIyTFLzOpvL5lAgoBn6	3676	93925976	P	Purworejo	2009-05-07	3306044705090001	Islam	RT 1/RW 6 Sarangan Krendetan Kec. Bagelen	Tohari	Purmaningsih
387	Selvia Rifma Ramadhani	12	\N	selvia.ramadhani	$2y$12$zhic47c.HMF9M5cZ4hlhfOB5ESpxqNupHZ.EAJqcnkVnxTZnrRyGu	3677	84179868	P	Boyolali	2008-09-12	3309195209080002	Islam	RT 0/RW 0  BANDUNGREJO Kec. Mranggen	Rifatul Asmak	Muslimah
390	Umi Karunia	12	\N	umi.karunia	$2y$12$7zrtB7uahqUTeuG5cm1MPehQPho1cERcImRpcBkm/aKW.Xr8Y1x5a	3680	91792790	P	Purworejo	2009-11-02	3306044211090001	Islam	RT 8/RW 2 Dremosari 2 Durensari Kec. Bagelen	Harjito	Tumini
392	Vebryana Salsabila	12	\N	vebryana.salsabila	$2y$12$bz7Q.GPf5rSkNbawe8HBL.vkTTGcMXCPv1Ef/swtwcFAVidqb4kKm	3682	97297589	P	Purworejo	2009-02-05	3306064502090003	Islam	RT 2/RW 2 Panggulan Desa/Kel. Donorati Kec. Purworejo	Dwi Iswantoro	Sri Purwanti
393	Wiedho Wati	12	\N	wiedho.wati	$2y$12$iVAc7VOD0w9BjQVgSs8K3.nmxBWBSppAQxJo5ZCx.jJ6jwEK8OCRm	3683	96321771	P	Purworejo	2009-08-21	3306116108090001	Islam	RT 4/RW 5 Nasaran Cangkrep Lor Kec. Purworejo	Mujianto	Haryani
396	Zulia Syifa Nur Arrazzaqu	12	\N	zulia.arrazzaqu	$2y$12$0.XNRE9zc29UD7r7qrosvenoPk7BEdilPa6wLnXCXPEjI1Nz4FBtW	3686	93373438	P	Purworejo	2009-05-30	3306067005090002	Islam	RT 1/RW 3 Projayan Cangkrep Kidul Kec. Purworejo	Yuliyanto	Ni Wayan Sumanis
259	Alexandria Barawati Mustika Putri	13	\N	alexandria.putri	$2y$12$egQxh3W5zntr5BSU7M2bGuqMZKeWOihwz7ol4nXxfUlOjj6hlbDG6	3688	89861218	P	Purworejo	2008-06-01	3306064106080003	Islam	RT 1/RW 2 Ngawang-Awang Brenggong Kec. Purworejo	R.Bayu Saputro	Era Ratih Ayu Puspita Sari
260	Ambar Setyaningrum	13	\N	ambar.setyaningrum	$2y$12$e0HtabTHpO9pC4JqlhmIN.e7Br6eWIO6QEPeu.orn6ac8tiPu745C	3689	3099534283	P	Purworejo	2009-02-02	3306044202090001	Islam	RT 4/RW 4 Kepondon Desa/Kel. Krendetan Kec. Bagelen	Slamet Suryadi	Sukesi
264	Aprilia Elvi Zahara	13	\N	aprilia.zahara	$2y$12$1ytjeAk/t8oUzPmcioxzeOEIFW9iR.8TJ6BhTrTmCMr.Cd88iprdK	3693	3092930136	P	Purworejo	2009-04-17	3306045704090001	Islam	RT 1/RW 4 Kepondon Desa/Kel. Krendetan Kec. Bagelen	Desy Ari Susanto	Dwi Prihatin
265	Azizah Nur Febriati	13	\N	azizah.febriati	$2y$12$lrIyQWgXnTDVwowwEd.WZ.BVPWNqiNjArArqJnGD6N.j9ZpwEwzJ.	3694	94498176	P	Gunung Kidul	2009-02-20	3306056002090001	Islam	RT 3/RW 2 Kedung Tileng Somongari Kec. Kaligesing	Agung Prasetyo	Lestari
267	Deaundre Adriel Bayutama	13	\N	deaundre.bayutama	$2y$12$73fzaUnpywnOOVVQX4USkumbqYKhwaZOWdFLIcwP6OT5QGh7pPDdC	3696	83509751	L	Bandung	2008-10-08	3277010810080005	Kristen	RT 2/RW 2 Purwodadi Purwodadi Kec. Purwodadi	Andreas Yuddy Anggoro	Heba Sulistiani
270	Dimas Fahri Prakosa	13	\N	dimas.prakosa	$2y$12$n53YH.C6O3CwZm4Qzx1xNuq8v4X8whzxy59EmRPYD3uOWXL30Yi2e	3699	89292230	L	Serang	2008-12-21	3306042112080001	Islam	RT 2/RW 1 Bagelen Desa/Kel. Bagelen Kec. Bagelen	Sugeng Prayitno	Musolikah
271	Fadila Dwi Astuti	13	\N	fadila.astuti	$2y$12$IQNPk3Gr2nRARMDHGUgBhOme0gR11rFTcluhdql2WukhDVWmseEZ.	3700	93498401	P	Purworejo	2009-05-27	3306046705090001	Islam	RT 2/RW 3 Tlogo Desa/Kel. Tlogokotes Kec. Bagelen	Darodi	Sukiswati
274	Hari Suswandaru Wirawan	13	\N	hari.wirawan	$2y$12$X3lOVGSWUfB1R008BwOu8.ZjnW5ql6Vq/f7OGdtkvOKzzjNB6qISC	3703	83415813	L	Purworejo	2008-10-02	3306040210080001	Islam	RT 1/RW 2 Krajan Wetan Kemanukan Kec. Bagelen	Irawan	Djamilah
277	Isnaini Rose Lestari	13	\N	isnaini.lestari	$2y$12$aZuWDm0vGaP.A8yGSVZ/GONjiwGc36QIU/J.hwi.TKs3Iz3uDWKmK	3706	94822178	P	Purworejo	2009-02-18	3306065802090004	Islam	RT 1/RW 1  WONOTULUS Kec. Purworejo	Sarimin	Isrofijah
278	Laila Arcika Kurniasih	13	\N	laila.kurniasih	$2y$12$Jy3/xf//pyI6nkbsYIHkxePtxAZgBGhIw5Fom2b78R3RdFcWso7hW	3707	91428401	P	Purworejo	2009-04-12	3306045204090001	Islam	RT 1/RW 2 Kenteng Desa/Kel. Somorejo Kec. Bagelen	Samingan	Sriyanti
280	Miftahul Hasanah	13	\N	miftahul.hasanah	$2y$12$DNO/I84rXhgfmCjVi0da/.tKGFQqYqxffm0cKtNwfTuoFr8zRduGe	3709	75832576	P	Purworejo	2009-02-04	3306044402090002	Islam	RT 2/RW 4 Sembir Desa/Kel. Bugel Kec. Bagelen	Mugiyo	Sri Suranti
283	Rahma Anjali Nareswari	13	\N	rahma.nareswari	$2y$12$ITJHhGwLDPsdrpNUOGAK1uCGxvCPwQ/ZVv5y7TjX0exnjb.PVHB7a	3712	99595135	P	Purworejo	2009-02-15	3306065502090002	Islam	RT 1/RW 2 Sidomulyo Desa/Kel. Sido Mulyo Kec. Purworejo	Catur Sari Pujo Utomo	Aruming Puji Wahyuni
284	Ramdhan Wahid Al Ahmad	13	\N	ramdhan.ahmad	$2y$12$mTRpznMSLyVjaqpyZtfxAOxomlibNl35KPVnscthM/TgU1YMAJHLK	3713	96385126	L	Purworejo	2009-09-13	3306051309090001	Islam	RT 2/RW 3 Tengahan Kaliharjo Kec. Kaligesing	Ahmad Yasin	Sueni
287	Saras Yunita Putri	13	\N	saras.putri	$2y$12$/W763vZ.FmqYVB33Z3/WI.lZGJfFtRMI8r2Hetpd8SY05cT.RdiNu	3716	99943276	P	Purworejo	2009-06-17	3306055706090001	Islam	RT 1/RW 10 Kaligono Desa/Kel. Kaligono Kec. Kaligesing	Suyanto	Siti Mulyana
289	Sifa Yenita Lestari	13	\N	sifa.lestari	$2y$12$hVFfVlHMXVNimoomSHnIyu4p74ER9NNbbQSHxjMh5PxsjQ/qh9RrW	3718	92315606	P	Purworejo	2009-10-24	3172046410090002	Islam	RT 2/RW 1 Kaliagung Desa/Kel. Sokoagung Kec. Bagelen	Jemingan	Senemi
290	Syifa Ramadhita Hapsari	13	\N	syifa.hapsari	$2y$12$iEhnXoigghlMHuNQh0Tz9ORwFTjOJ7xONNf0EnTbBaB3NuaDTITx.	3719	99940963	P	Tangerang	2009-08-19	3306065908090002	Islam	RT 3/RW 2 Kembaran Semawung Kec. Purworejo	Sumarlan	Daryati
293	Alfina Juniana Sari	14	\N	alfina.sari	$2y$12$3burwJIy399yE.ilw0RqreudTYGK/UH0SKX8bFf4Ykxi2yT4xJoaa	3722	92416643	P	Purworejo	2009-06-09	3306154906090001	Islam	RT 4/RW 2  Desa/Kel. Trirejo Kec. Loano	Riyanto	Siti Agustina
294	Cera Arzika	14	\N	cera.arzika	$2y$12$Kw/S2UegAZHlVvvCH8RG7OyhMCiMwDJZHEqEBrUEN3uWVEUiJSD/.	3723	97900999	P	Purworejo	2009-04-24	3306066404090001	Islam	RT 2/RW 3 Sejati Desa/Kel. Brenggong Kec. Purworejo	Wiwit Asmajie	Listiyanti Winarsih
298	Eka Duwik Prasetiyo	14	\N	eka.prasetiyo	$2y$12$BSVC5y20X3dC8MLpKnouo.df5coLqQT8wfO9CvyvDcQci2Q42/uZe	3727	93340823	L	Purworejo	2009-03-24	3306042403090001	Islam	RT 13/RW 4 Durenombo I Desa/Kel. Durensari Kec. Bagelen	Triyono	Seniyem
299	Fiandra Iqbal Maulana	14	\N	fiandra.maulana	$2y$12$L4jD91Kgnd/3iuHSMAsGheLKHxga0sWHDNzG6wmLujc/9odIdxIWK	3728	88700450	L	Purworejo	2008-12-10	3306121012080001	Islam	RT 2/RW 4 Mbulu Kedunglo Kec. Kemiri	Hadiyono	Sopiyah
303	Laila Naswa Jannah	14	\N	laila.jannah	$2y$12$kjJjVjAdq2GJ/NmSAvvqAubQKfKw9SupTnV/yPbPxMyVxwV1qA4vi	3732	96518735	P	Purworejo	2009-06-23	3306046306090001	Islam	RT 4/RW 2 Sekangun Desa/Kel. Sokoagung Kec. Bagelen	Nasum	Suparti
304	Lare Prayudia Utami	14	\N	lare.utami	$2y$12$V7ghVEjevabWCxSR3H.RRukDIvW95m/w/Hbd7F3s31wLas6WGRBB2	3733	86470791	P	Purworejo	2008-09-18	3306045809080001	Islam	RT 1/RW 2 Kahuripan Kalirejo Kec. Bagelen	Cipto Prayitno	Yuli Astuti
307	Mao Nabila Bunga Cahyaningrum	14	\N	mao.cahyaningrum	$2y$12$UDdX2iCONyEZljbonAciS.PxsaPwPyBdK5qTBlqfXGFEX30kPAqsq	3736	109573149	P	Purworejo	2010-02-26	3306056602100001	Islam	RT /RW  Katerban donorejo Kec. Kaligesing	Margani	Sriminarti
308	Muhammad Fahrel Alansyah	14	\N	muhammad.alansyah	$2y$12$v.vpBzx1XYrRSI4mjeMiUuvxKd04Knv4fdbl064JIlBDMQk.2b8fi	3737	95549887	L	Purworejo	2009-07-19	3306021907090001	Islam	RT 1/RW 1 Ngaglik Desa/Kel. Wonosri Kec. Ngombol	Dendi	Tantiati
310	Nailina Indah Pratiwi	14	\N	nailina.pratiwi	$2y$12$NaAqALPZpbbxIRU7kQZdEO2zS5ZcTeqBCBgQ0CJcm5zJBNcOFnCqe	3739	91738755	P	Purworejo	2009-06-23	3306066306090001	Islam	RT 3/RW 5 Cangkrep Lor Cangkrep Lor Kec. Purworejo	Saryanto	Ari Irawati
313	Peny Pujiati	14	\N	peny.pujiati	$2y$12$1tUU9CYPkL0aSHTKkqSFYuNaIX5B2bHuWaUCfGrKy7WWQ8aW/wUUe	3742	81259033	P	Purworejo	2008-02-22	3306046202080002	Islam	RT 1/RW 2 Krajan Wetan Kemanukan Kec. Bagelen	Indarto	Tri Andri Alung
314	Poundra Praditya Daniswara	14	\N	poundra.daniswara	$2y$12$WU3dmWOwnJNpvoKupmsX3O1qoxv0NIGCwggNgUExfnZVlhppvflVu	3743	85836707	L	Purworejo	2008-07-26	3306122607080001	Islam	RT 2/RW 1 Rebug Lor Rebug Kec. Kemiri	Lilik Suryonoto	Sumartini
316	Rahayu Setianingsih	14	\N	rahayu.setianingsih	$2y$12$aGs5eNhQq560NcYimIDV/OGC3N0Ha1juPgBcYyO9CJTyCEKcJMLqu	3745	94502063	P	Purworejo	2009-03-27	3306056703090001	Islam	RT 2/RW 1 Krajan Kaligono Kec. Kaligesing	Hartono	Saminah
319	Salma Rahmania Kirom	14	\N	salma.kirom	$2y$12$ROUiFyCWUh/DHres7svFe.gM0e7qm8lM66iNbL/ogZASKALtd2VOa	3748	99287994	P	Purworejo	2009-01-25	3306066501090001	Islam	RT 1/RW 7 Karang Anyar Cangkrep Kidul Kec. Purworejo	Sartiman	Sariah
320	Silvia Dyah Apriliani	14	\N	silvia.apriliani	$2y$12$RQVt2bVdAhsOKOZmmrrQ.er89PFiyRD8qczURHNvlFqlayL69OeJK	3750	95062901	P	Purworejo	2009-04-24	3306046404090001	Islam	RT 1/RW 5 Tepus Desa/Kel. Somorejo Kec. Bagelen	Sarjo	Satinah
324	Vina Maharani	14	\N	vina.maharani	$2y$12$net/TVItQo4.kdvZJm97hOXegCXtzJkDXm7r2Bowr06K7UgG46hMS	3753	98377277	P	Purworejo	2009-01-23	3306046301090001	Islam	RT 8/RW 3 Dusun Kedungrejo Sokoagung Kec. Bagelen	Jumar	Lina Lestari
326	Wiji Larasati Khoirunisa	14	\N	wiji.khoirunisa	$2y$12$Q0NjGjppaWsRs7msWRIRyudahE.sS5TMFcnnMN8bCmS6CK.ihmJqK	3755	83867999	P	Purworejo	2008-01-10	3306055001080002	Islam	RT 2/RW 4 Kliwonan Desa/Kel. Kedunggubah Kec. Kaligesing	Purnomo Widiyanto	Paijem
327	Yeni Subekti	14	\N	yeni.subekti	$2y$12$s1ck3XmV3bcvRMYvvpDW9OkIsPDylfTd46fgZCF0PiY36byOvYIae	3756	82079225	P	Purworejo	2008-08-30	3306057008080002	Islam	RT 3/RW 4 Sijanur Somongari Kec. Kaligesing	Sarjiyono	Timah
151	Abi Atok Lesmana	1	\N	abi.lesmana	$2y$12$johEXwp0RDXHeA82NEmieuw6fo2w5p/6rB8ETKnc1BOuidBIsG19q	3757	93853066	L	Purworejo	2009-03-15	3306051503090002	Islam	RT 5/RW 6 Desa/Kel. Cangkrep Lor Kec. Purworejo	Yatmanto	Anik Rumantikawati
152	Achmad Dava Izzudin	1	\N	achmad.izzudin	$2y$12$tgYwmMivf0JvWdfemAUmPu/4VMr8kwLfGmxho0T.qFYoUeQUl1JVK	3758	91415951	L	Purworejo	2009-04-29	3306122904090003	Islam	RT 2/RW 3 Sawangan Girimulyo Kec. Kemiri	Khoirin	Heru Susiyati
155	Akhyar Muthohar	1	\N	akhyar.muthohar	$2y$12$HGYt89l8tNE68lsOFNb6P.Lj1RCxiITJ0dLbJlQF.aqYoxnIV.nZu	3761	109351941	L	Purworejo	2010-06-22	3306062206100001	Islam	RT 1/RW 6 Gunung Buthak Desa/Kel. Pacekelan Kec. Purworejo	Toib	Suprapti
156	Asmar Dwi Atmoko	1	\N	asmar.atmoko	$2y$12$V1pav.Kw31qa/WjMSRj1KuaGNjq/Z3SBKyup6Qf6FmUrduTtXBMaW	3762	107836069	L	Purworejo	2010-03-01	3306040103100001	Islam	RT 1/RW 2 Sikuning Hargorojo Kec. Bagelen	Sumedi	Pujiani
17	Dwi Astuti Arsianti	6	\N	dwi.arsianti	$2y$12$VFy.qjKscVipSFSsOdHfMOfFxTwhkdFKNPC0XPAn1kD/tHEJ6bClq	3945	95472755	P	Purworejo	2009-05-02	3306114205090002	Islam	RT 3/RW 2 Sikuning Rt 003 Rw 002 Hargorojo Bagelen Hargorojo Kec. Bagelen	Haryanto	Wariyati
19	Een Neevianasari	6	\N	een.neevianasari	$2y$12$L.HUAXrIEw2hToBQ3lRKreci.H0Lb0FLSUMdAmC7BCcgL3mEk79hm	3947	102209183	P	Purworejo	2010-10-15	3306055510100001	Islam	RT 2/RW 4 Rejosari Donorejo Kec. Kaligesing	Setyadi	Ponisah
21	Fayola Avrilyzia Aqeela	6	\N	fayola.aqeela	$2y$12$Io3fZeYGb/iMya3gVEnEyOXQ65yqbrNTmpsNMkR2cpOBNaZM2y7XK	3949	108213318	P	Purworejo	2010-04-23	3306096304100001	Islam	RT 2/RW 2 Jogoresan Desa/Kel. Ganggeng Kec. Purworejo	Suryono	Emallia Mahardika
23	Inesta Yulia Sari	6	\N	inesta.sari	$2y$12$FI28jan0wG.UBZECU.LtB.dnYqJ1QQHu6qXTKBEKBB9IaZ2hZ295u	3951	109628289	P	Purworejo	2010-07-15	3306045507100001	Islam	RT 3/RW 2 Kahuripan Desa/Kel. Kalirejo Kec. Bagelen	Ahmad Mustofa	Supanti
25	Latifah Nur Azkiya	6	\N	latifah.azkiya	$2y$12$0e/lIKIGwhm13RiJ3nWEI.dD.XwV787/5bVjSSkbiwDvFAkKPxut.	3953	106317442	P	Purworejo	2010-05-30	3306047005100003	Islam	RT 1/RW 2 Kuwojo Rt 001 Rw 002, Dadirejo, Bagelen Dadirejo Kec. Bagelen	Har Sutrisno	Tusmiati
27	Mutiara Chesillia Saputri	6	\N	mutiara.saputri	$2y$12$9l.dyk549XVlLvNpqJ/6Meks9TirQaamRnOLmEpT/juEc9SaDneSi	3955	108817254	P	Purworejo	2010-01-01	3306054101100001	Islam	RT 3/RW 1 Sigodog Desa/Kel. Purbowono Kec. Kaligesing	Triyanto	Ichti Nuriyah
29	Naila Fajriyatul Khusna	6	\N	naila.khusna	$2y$12$mAV29jJAMAE/TXv/kr/Snuin8Ffrd7yPR5h9so9Q5/KVSu4rZ5D.G	3957	104955133	P	Purworejo	2010-04-20	3306036004100001	Islam	RT 1/RW 3 Dusun Dua Geparang Kec. Purwodadi	Toharman	Khoiriyah
30	Naylla Safa Amandary	6	\N	naylla.amandary	$2y$12$67bOSo/YZ4MkFyDlPStRAudyGjEhmRAAN1vcZqR.v8RncA56oNlLO	3958	99603159	P	Tangerang	2009-12-15	3671135512090004	Islam	RT 2/RW 2 Puntuk Desa/Kel. Salam Kec. Gebang	Dwi Sucahyono	Suparmi Anggoro Dewi
33	Rahayuningtyas	6	\N	rahayuningtyas	$2y$12$O8vXYl2X642unEoGtEtXbOJA/.iDDHJP4qBVeFQZ1PeZQ1DfOaa1u	3961	103917185	P	Purworejo	2010-06-11	3306045106100001	Islam	RT 3/RW 1 Sembir Rt 003 Rw 001 Somorejo Bagelen Desa/Kel. Somorejo Kec. Bagelen	Narno	Wiwin Islindawati
34	Reivan Oktaviano	6	\N	reivan.oktaviano	$2y$12$btxzhB3/qQFemaGAwDAjs.2Fon1IzI4LOPM6JW9WXSlJUaFEjzeGa	3962	92256056	L	Purworejo	2009-10-27	3306042710090002	Islam	RT 7/RW 1 Keposong Desa/Kel. Krendetan Kec. Bagelen	Satino	Sugi Herawati
37	Sazkiya Khoirunnisa	6	\N	sazkiya.khoirunnisa	$2y$12$BOOPcAOm6Xc/kJhpXRJpNuq.4YRyRfnVoUD2hiJZR2SkTjSXTvcDe	3965	97952310	P	Garut	2009-08-18	3306045808090001	Islam	RT 2/RW 2 Sikuning Rt 002 Rw 002, Hargorojo, Bagelen Desa/Kel. Hargorojo Kec. Bagelen	Barno	Siti Rodiah
39	Shafa Choiril Munna	6	\N	shafa.munna	$2y$12$vWaItieykRE/UkSTs2YQyuI.ugBKu7pkdR38WbfiHvcBDamX94Qo2	3967	104387402	P	Purworejo	2010-04-18	3306065804100002	Islam	RT 2/RW 5 Kemantren Ii Desa/Kel. Semawung Kec. Purworejo	Mulyono	Simpeni
159	Davin Akbar Prasetyo	1	\N	davin.prasetyo	$2y$12$j/R5URe2psNnoucWiaqKwO22Rnn42Plp9m6MOKXHEB7I3QoH/uKCO	3765	85609229	L	Purworejo	2008-03-28	3306072803080001	Islam	RT 2/RW 4 Popongan Popongan Kec. Banyu Urip	Trisno Prasetyo	Sunaryati
162	Fakhri Nur Fadli	1	\N	fakhri.fadli	$2y$12$hBPAda8lJe/ptlnWluyUQuasVyV0//EYuUdORXfynPvhWM5hzZCJq	3768	97194844	L	Purworejo	2009-08-11	3306151108090001	Islam	RT 2/RW 5 Kalinongko Kec. Loano	Pamuji	Setyaningsih
164	Galih Sasongko	1	\N	galih.sasongko	$2y$12$BobvkrMExDPLZDJT/8CRcO4owkPH0kA03J7aMc9q3OHvflvUl8w1K	3770	86414376	L	Purworejo	2008-05-21	3306062105080001	Islam	RT 3/RW 2 Krajan Wetan Desa/Kel. Kemanukan Kec. Bagelen		Juariyah
165	Ganjar Prio Pambudi	1	\N	ganjar.pambudi	$2y$12$l4mNlKYrSuEu9PejRVWyX.TOU9s9HqlsyOUZw58m6c8Zy8bN.fq0K	3771	102274895	L	Purworejo	2010-09-23	3306062309100001	Islam	RT 4/RW 2 Wonoroto Kec. Purworejo	Supadi	Ambar Sari
168	Hema Putra Widyantoro	1	\N	hema.widyantoro	$2y$12$Zy3ZQK1xmGUxyPK0SG4rzu2/KPjc55kMHxi9RuUjAtAQA4bgC5JgG	3774	103658885	L	Purworejo	2010-01-30	3306043001100001	Budha	RT 3/RW 1 Krajan Kulon Kemanukan Kec. Bagelen	Gatot Didit Widiantoro	Nuryanti
169	Jihan Dwi Shafariyani	1	\N	jihan.shafariyani	$2y$12$8.bG.TXUFhG.XHUVcSqhdeY8kJ76hNSwVw7Cq8whDQtcbTe9n/9Qy	3775	107306141	P	Purworejo	2010-01-24	3306126401100001	Islam	RT 1/RW 3 Kliwonan Girimulyo Kec. Kemiri	Chafid	Sukarti
173	Panji Pamungkas	1	\N	panji.pamungkas	$2y$12$4Z5O1/IHJMqFAYtIeYoN.OI4m7/vnwAde/.V9zP1Q181x8UA.2Ttq	3779	105897059	L	Purworejo	2010-06-11	3306051106100001	Islam	RT 4/RW 3 Jeketro Desa/Kel. Kaligono Kec. Kaligesing	Muhamad Riyadi	Leginah
174	Radisa Agitna Salsabila	1	\N	radisa.salsabila	$2y$12$SjBk3keeP3BObVNeB35SruHIjqmqrlphN7AyefS0pbGwnfDrT.lJC	3780	3099605215	P	Purworejo	2009-05-10	3306065005090002	Islam	RT 1/RW 2 Krajan Cangkrep Kidul Kec. Purworejo	Kasiman	Yulinar
177	Rangga Nukbiantoro	1	\N	rangga.nukbiantoro	$2y$12$nYGhsU9n6xz30xYRAqvgaukc/qVCxFWVEnReOMU21Y7gUZRMg2PKS	3783	83231511	L	Purworejo	2008-05-09	3306070905080002	Islam	RT 1/RW 3 Borogunung Boro Kulon Kec. Banyu Urip	Suhatmanto	Wiwik Umiyati
178	Ridho Saputro	1	\N	ridho.saputro	$2y$12$4fOMhbvLNUrIw/s./8gekeK5pXl0x2Gryi5f.KaDXZosgtn22oLme	3784	93921498	L	Purworejo	2009-12-25	3306152512090001	Islam	RT 1/RW 1 Maron Maron Kec. Loano	Ratmoyo	Sarinem
181	Satrio Alif Nurteguh Ardyantono	1	\N	satrio.ardyantono	$2y$12$319N.aV2w..utrontGqf3O/nSYDiimYSC.U9iFBdzJ97RcEf3/U26	3787	107427069	L	Purworejo	2010-07-03	3306060307100001	Islam	RT 1/RW 3 Popongan Kidul Desa/Kel. Popongan Kec. Banyu Urip	Ardy Kristanto	Ajeng Meilina Prastiwaningtyas
183	Trida Oktama Nugroho	1	\N	trida.nugroho	$2y$12$FmYuZKykm2IcHaaU3m3hEunk8gmM1bvzECyUp9EgYl3S23mvPUmz.	3789	96451910	L	Purworejo	2009-10-16	3306061610090001	Islam	RT 1/RW 1 Keseneng Keseneng Kec. Purworejo	Karsiyat	Sawitri
184	Ulfa Nikmah	1	\N	ulfa.nikmah	$2y$12$dJrNaigxjBhZRM8MPPnZe.RyBkjLG2NiT0itCheMEyjVsNONSfCUm	3790	105326157	P	Purworejo	2010-06-17	3306155706100001	Islam	RT 2/RW 2 Krajan Lor Desa/Kel. Kalikalong Kec. Loano	Muntolip	Mudrikah
187	Adrian Jupi Erlangga	2	\N	adrian.erlangga	$2y$12$mwqq2pMPZgrrLN51eNF5feaI7J3ZdYxZVFEZg/mUkSKjv10H84Viq	3793	94050337	L	Purworejo	2009-01-17	3306141701090001	Islam	RT 2/RW 4 Kroyo Kidul Kroyo Kec. Gebang	Sugeng Widodo	Puji Astuti
190	Akbar Mulia Sudrajat	2	\N	akbar.sudrajat	$2y$12$Pu2qQoLKpgPJ7NFcLf9p7.UalpTIk3M.wtc0/hABMIYq2KYIeQ/PS	3796	108140172	L	Purworejo	2010-04-24	3471102404100001	Islam	RT 2/RW 1 Pucangagung Pucangagung Kec. Bayan	Junaedi Sudrajat	Tri Maelani
191	Allin Amelia	2	\N	allin.amelia	$2y$12$OvHuLZSzlRxL/G0iuz9SkuDTGiVkVlE7/eQhAv.T5lt7EE8o/0/eG	3797	106755638	P	Purworejo	2010-05-22	3306066205100001	Islam	RT 1/RW 9 Kalitambak Desa/Kel. Sido Mulyo Kec. Purworejo	Amat Suhadi	Sukini
194	Celvin Aditya Putra	2	\N	celvin.putra	$2y$12$lctoR5Gdbh/50dHE7YJhJeTK36IH7c98gzWk4.Bz48mZL76OCcE5G	3800	98128877	L	Purworejo	2009-12-09	3306040912090001	Islam	RT 1/RW 1 Semono Kec. Bagelen	Hidayah	Hidayah
195	Daffa Khoirul Zakky Mushafar	2	\N	daffa.mushafar	$2y$12$n4wEt.qU9qBYykoOTNsOaeBWIhSQ8665.7dH/70fP6tSIpoT7we8q	3801	104784382	L	Purworejo	2010-01-17	3306061701100001	Islam	RT 2/RW 5 Baledono Baledono Kec. Purworejo	Pujiono	Khomsah Surani
197	Edi Setiawan	2	\N	edi.setiawan	$2y$12$oe/6xS5DTADMIQCow9IC2ezBfQsoykbCU0X3lXZXY1wLm8Omq3lo.	3803	103639459	L	Purworejo	2010-03-05	3306050503100001	Islam	RT 4/RW 3 Sawahan Somongari Kec. Kaligesing	Jumadi	Ngatiyem
200	Firdan Firmansyah	2	\N	firdan.firmansyah	$2y$12$p6IISdX1iF/pkBUpM/esE.xc0H8rsJQyWFxILY2P6MApKInMhVEvK	3806	103183721	L	Purworejo	2010-10-17	3306061710100008	Islam	RT 3/RW 1 Donorati Desa/Kel. Donorati Kec. Purworejo	Rochimah	Rochimah
201	Galih Fajar Ardana	2	\N	galih.ardana	$2y$12$flFblqN.Y.kM8QpwNPpKJ.VKOLDgINco.XJVSE/KSt/NXIgxHSKJS	3807		L	Purworejo	2009-11-10		Islam	RT 04/ RW 01 Tawangsari, Kec. Kaligesing Kab. Purworejo	Dedi	Turiyah
204	Muhammad Azano Widiansa	2	\N	muhammad.widiansa	$2y$12$W8UDZiElKbuhDyceiSzggeWYc8T8EsI377aYUssvkMpZZxA4IU6f.	3810	3109385898	L	Purworejo	2010-07-13	3306081307100001	Islam	RT 8/RW 1 Sucenjuru Tengah Kec. Bayan	Slamet Widodo	Umrotun
205	Muhammad Havid Nur Ramadhan	2	\N	muhammad.ramadhan	$2y$12$3fGj4C9JMuoCKrADDErXtOURgp5HKxPpBzfWis.EPrtqvgxm/pdEi	3811	99128270	L	Purworejo	2009-09-04	3306060409090003	Islam	RT 1/RW 2 Keseneng Keseneng Kec. Purworejo	Widodo	Watinah
207	Muhammad Rizqi Ali Hamzah	2	\N	muhammad.hamzah	$2y$12$Du7L/LVUVbW3XNv9wh/PcOjCdufJKOJJPpgvhAaZRK1NogBWotl5K	3813	103462110	L	Purworejo	2010-04-12	3306061204100002	Islam	RT 2/RW 3 Sejati Desa/Kel. Brenggong Kec. Purworejo	Suratmo	Eniati
210	Rafa Aray Ramadhani	2	\N	rafa.ramadhani	$2y$12$Yok/6.0vbGq2riZADLznseC91lGpGFFipK.hok0NoFv76zG4Fkpp6	3816	91746045	L	Tangerang	2009-09-12	3671091209090004	Islam	RT 1/RW 3 Mranti Kec. Purworejo	Ponco Waluyo Nugroho	Yudianah
211	Rafa Aryadi Setiawan	2	\N	rafa.setiawan	$2y$12$jeONukYURzvGFbtsJELYJ.nyKLOBtXxs8j.Zks.q7LoRSt4AxqHw.	3817	103245231	L	Purworejo	2010-02-25	3306062502100002	Islam	RT 3/RW 5 Desa/Kel. Baledono Kec. Purworejo	Pariyadi	Riyati
213	Rayhan Maulana Alifiansyah	2	\N	rayhan.alifiansyah	$2y$12$Lo96zJ1noJBqHhUoFxMokOzXcBh1L.vlhUlYPt.B0qh.hdHNYlhyG	3819	101651031	L	Purworejo	2010-03-06	3306040603100001	Islam	RT 3/RW 2 Krajan Wetan Desa/Kel. Kemanukan Kec. Bagelen	Purbo Yuwono	Suwartini
217	Tegar Fahreza	2	\N	tegar.fahreza	$2y$12$fmlzecQLUHJ72JTdjhMBOuDxWxcempzgtDv3lk22btvY0StsuI8rK	3823	95625845	L	Purworejo	2009-08-08	3306040808090002	Islam	RT 2/RW 5 Jolotundo Desa/Kel. Kemanukan Kec. Bagelen	Binarman	Paryatun
219	Vitra Aji Pangestu	2	\N	vitra.pangestu	$2y$12$vhVQwOXUHsRV4e5EdPT.OuV5t77tZPyYceCqkH5m/0/z1g3QAI7VK	3825	93589174	L	Purworejo	2009-10-16	3306050610090002	Islam	RT 7/RW 1 Katerban Donorejo Kec. Kaligesing	Sukayat	Herna Wati Rahayu
222	Afiq Tamam Na'Imullah	3	\N	afiq.naimullah	$2y$12$0AAhrYlEXMXvzxdPU5MhIOgPwqyTCTKgOGsum/XoJD5axsGRCicrS	3828	94912945	L	Purworejo	2009-07-25	3306062507090001	Islam	RT 3/RW 4 Desa/Kel. Tambakrejo Kec. Purworejo	Sunaryo	Lestari
224	Ahmad Robit Zain Fikri	3	\N	ahmad.fikri	$2y$12$7fWyvSG.7nRQX0Ic9S7esuc9/2hdW2qQ0flzbqDiSNnEYaYXQxFV2	3830	91299993	L	Purworejo	2009-12-10	3306061012090001	Islam	RT 3/RW 2 Krajan Ii Wonotulus Kec. Purworejo	Sarifudin	Rofingah
225	Aldo Saputra Mahardhika	3	\N	aldo.mahardhika	$2y$12$J9cyWxfBwBSjUQ7KZ6ogeeUh4s7mNOPsI00je./ciUirbAP8NbQv2	3831	98104630	L	Kulon Progo	2009-04-24	3401042404090002	Islam	RT 1/RW 4 Gumuk Piji Kec. Bagelen	Marjudiyanto	Ariyanti
226	Alvino Abi Samudra	3	\N	alvino.samudra	$2y$12$A6p2Ga7KTTW7a1ZBJoPB7u/xpZSGuA8vl.XzN1UAm/bpXG/GxuV/S	3832	106133530	L	Purworejo	2010-06-05	3306150506100001	Islam	RT 1/RW 1 Krandon Desa/Kel. Cangkrep Kidul Kec. Purworejo	Amat Nur Imam	Sutrisni
228	Ardian Nur Hidayanto	3	\N	ardian.hidayanto	$2y$12$/H9Vgk5DC/f8KOkGNIyDK.U/MGV5Jc24lChGiIYCGVZ1zFzk67Wmi	3834	94416796	L	Purworejo	2009-08-01	3306150108090003	Islam	RT 1/RW 2 Sijengking Kalinongko Kec. Loano	Mardiyanto	Umi Nurhidayah
231	Damar Wisnu Ramadhan	3	\N	damar.ramadhan	$2y$12$NI8G.cr4g2whPBm2oyC57OACoozfUEKPi8w7ZbQQSCV4ySptGY..u	3837	106745146	L	Tangerang	2010-08-14	3603121408100012	Islam	RT 3/RW 2 Gelam Jaya Kec. Pasar Kemis	Sugiyono	Suyekti
234	Dhimas Dwi Cahyo	3	\N	dhimas.cahyo	$2y$12$7kmJbdFeTIx/1o1fDmA7WObt0MUqvAlFKyOuZM2df7pbRnYBWyQQS	3840		L		\N					
235	Dimas Ardianto Saputra	3	\N	dimas.saputra	$2y$12$piPKTv24cmFr4W.1gABQWu0NOKMBMuXSiNWr95J7Z6XQxDywd8ISu	3841		L	Purworejo	2009-10-07		Islam	RT 03/ RW 01 Pandanrejo, Kec. Kaligesing Kab. Purworejo	Ngatimin	Triningsih
237	Ghufron Ardiansyah	3	\N	ghufron.ardiansyah	$2y$12$LVudWIGHBpf9eZvGmq7nJuigFpVrAezqk/50ZVIbBhCCDbk0yh7M.	3843	94586544	L	Purworejo	2009-12-23	3306062312090002	Islam	RT 4/RW 8 Baledono Krajan Baledono Kec. Purworejo	Raidho Burhanudin	Umi Dian Lestari
238	Ifank Jaya Nugraha	3	\N	ifank.nugraha	$2y$12$9Kr3Y4japmoo2ub569LoC.1DWGKd5xhed0KJ3ygnovnuT7Lrbd4nu	3844	94226404	L	Purworejo	2009-11-20	3306042011090002	Islam	RT 3/RW 6 Kauman Timur Rt 003 Rw 006, Bagelen, Bagelen Desa/Kel. Bagelen Kec. Bagelen	Asep Nugraha	Sunarti
241	Muhammad Azka Nazril Hidayat	3	\N	muhammad.hidayat	$2y$12$b2Ny7xsxJaSK07SK0zABLuLGJm7TVWeg1ceQ3EdayY92zS.RL.BuK	3847	109719152	L	Garut	2010-04-16	3205011604100001	Islam	RT 3/RW 3 Karang Sari Desa/Kel. Kemanukan Kec. Bagelen	Saepul Hidayat	Rita Budiarti
244	Muhammad Raditya Al Fathir	3	\N	muhammad.fathir	$2y$12$SAQ6zjQu.yL2IJkHmb76YuRi05APzEych534FqnVrURbaNuQfv9Pu	3850	107536714	L	Purworejo	2010-05-16	3306061605100002	Islam	RT 1/RW 5 Ngentak Desa/Kel. Baledono Kec. Purworejo	Yudi Aryanto	Sunar Wijiati
245	Mustaqiim Ziyadur Rofiq	3	\N	mustaqiim.rofiq	$2y$12$I31dNu3qGku34bqVpQFVT.N8VzXSSoX.4IhslJCzU3.bFlDiKaARO	3851	97879821	L	Purworejo	2009-11-07	3306150711090002	Islam	RT 3/RW 2 Karangjati Desa/Kel. Karangrejo Kec. Loano	Supriyadi	Prihatin
248	Rakha Zhudi Naufal	3	\N	rakha.naufal	$2y$12$xwPDxOJpE3v6a8ofXevTAOWuOc7yCdLrxlw7QxkA5f7Bu6TA96Pnq	3854	105280475	L	Purworejo	2010-01-02	3306060201100003	Islam	RT 6/RW 1 Desa/Kel. Baledono Kec. Purworejo	Suswanto	Supriatin
250	Sardiyono	3	\N	sardiyono	$2y$12$q2ojVFHLnUzJUVge3wRPdudcV6YzbBOwB0wIJ1MeRRBjIbV8DrkKW	3856	97572011	L	Purworejo	2009-11-20	3306042011090001	Islam	RT 3/RW 4 Karangrejo Desa/Kel. Kemanukan Kec. Bagelen	Kusnan	Jumiyati
253	Tya Mutiara Ramadhani	3	\N	tya.ramadhani	$2y$12$A/MKnZ5SKtOgL0vK/nahbeth6fAqfj2oNyIJzuDKGTutM6FRD18py	3859	97927790	L	Purworejo	2009-06-13	3306041306090001	Islam	RT 3/RW 8 Baledono Kec. Purworejo	Margino	Rita Marlita
255	Wahyu Eka Saputra	3	\N	wahyu.saputra	$2y$12$i67QIeBH6qC4q9HJ3AnzVeuOmPo2XBJICJYMMOwiu3i6whdVVXf/.	3861	95355520	L	Purworejo	2009-08-08	3306040808090003	Islam	RT 3/RW 4 Gumuk Desa/Kel. Piji Kec. Bagelen	Sigit Basuki	Pangestuti
256	Wahyu Nugroho	3	\N	wahyu.nugroho	$2y$12$08bh35ld9yRJApTbBMF5.eQb1TSiOvvalZnWUOfUqzuNKYxrCMr0W	3862	106961283	L	Purworejo	2010-02-21	3306082102100001	Islam	RT 1/RW 3 Kaliseng Desa/Kel. Jelok Kec. Kaligesing	Edy Triyono	Isnur Chotimah
79	Aida Eka Labibah	4	\N	aida.labibah	$2y$12$eS9hPTgJjHR2jQctcl7KXu8aqlHcTgshknjNcfrJXAgIM1Vz8Pxqu	3864	91406042	P	Purworejo	2009-09-29	3306046909090001	Islam	RT 1/RW 4 Karangrejo Kemanukan Kec. Bagelen	Ari Seno	Puji Lestari
81	Anggita Dewi Prastiwi	4	\N	anggita.prastiwi	$2y$12$Y6Fx8qDupcZOMozvWr3A9ubXgQCrEbNo7P/q1Nrk5hdbuscUcTFr.	3866	99264567	P	Purworejo	2009-09-03	3306044309090001	Islam	RT 2/RW 5 Tepus Rt 002 Rw 005, Somorejo, Bagelen Desa/Kel. Somorejo Kec. Bagelen	Sartun	Sugianti
82	Anis Khoirunnisa'	4	\N	anis.khoirunnisa	$2y$12$yf6RU2dL/A.puyZySwjzbeHhSiewB7LYDtHBjO113jjnsOMrPMzL6	3867	3104159173	P	Purworejo	2010-06-09	3306064906100002	Islam	RT 3/RW 4 Cangkrep Kidul Kec. Purworejo	-	Siti Rochanah
85	Cinta Amelia Febriana	4	\N	cinta.febriana	$2y$12$EzOtdt5fF465oSo9un.RvO7dgo2SesirLyT9tvMqC5E68sza7oa.6	3870	103558806	P	Purworejo	2010-02-01	3306074102100002	Islam	RT 1/RW 1 Gunung Butak Kidul Desa/Kel. Pacekelan Kec. Purworejo	Slamet Sartono	Tri Yanuari
86	Danisha Fahma Sania	4	\N	danisha.sania	$2y$12$YeCeRMJ0PwUsWpn0hlLhie.gsfSERR.8z80IPbsBEdVEMZQk9KeiK	3871	109240217	P	Purworejo	2010-04-24	3306066404100001	Islam	RT 2/RW 1 Cangkreplor Desa/Kel. Cangkrep Lor Kec. Purworejo	Ari Prastowo	Umi Salamah
88	Dianata Andari Waluyo	4	\N	dianata.waluyo	$2y$12$taGWDvr0YVIBzheNVzjwN.bTiLmvTJVdar/yRjrvcfaIJfSlzAQ66	3873	85657440	P	Purworejo	2008-10-31	3306047110080002	Islam	RT 4/RW 6 Pucungan Rt 004 Rw 005, Bapangsari, Bagelen Bapangsari Kec. Bagelen	Supriyono	Mangiyah Fitriani
89	Dinda Dwi Nuraini	4	\N	dinda.nuraini	$2y$12$aV4uk2KDFUn85.mZ4taJSus6.hlC3G1sKWlumexDoeHRgTPHEHBqy	3874	104998668	P	Purworejo	2010-03-07	3306044703100001	Islam	RT 1/RW 1 Krajan Desa/Kel. Tlogokotes Kec. Bagelen	Bin Sutono	Tutik Nurkayati
92	Ernawati	4	\N	ernawati	$2y$12$CDFRaE5ey2EVtZKZyBGvI.RrrlKS3ku2AornVb2u4qN4fETfasqNq	3877	96948625	P	Wonosobo	2009-09-15	3307025509090001	Islam	RT 1/RW 1 Semono Semono Kec. Bagelen	Arif	Sutari
95	Marta Sintia Wardani	4	\N	marta.wardani	$2y$12$k8FOKuTC7isEuwsicmPSlOvvrL2nuU.iRaubbAGOwAJWcrg7eHYR6	3880		P	Purworejo	2010-03-11		Islam	RT 005/ RW 002 Sigula Purbowono, Kec. Kaligesing Kab. Purworejo	Jarno	Riyanti
96	Mutiara Nur Asyifa	4	\N	mutiara.asyifa	$2y$12$8JPSJ345Oxd0.4Lxby404.bZuTLaOoOL0KGy4U2pO2lEoolKlG.Va	3881	91235955	P	Purworejo	2009-08-14	3306065408090003	Islam	RT 4/RW 9 Sabrang Baledono Kec. Purworejo	Saifur Rohman	Tuti
99	Nadia Arista	4	\N	nadia.arista	$2y$12$3Sx0UpBaTF8.045U7sUDqezt9tMlDMBXZ.2YPIDEkmfZCN4hbS1Zq	3884	92111858	P	Purworejo	2009-03-27	3306156703090001	Islam	RT 2/RW 1 Sejiwan Lor Desa/Kel. Trirejo Kec. Loano	Sutrisno	Nur Dewi Zulaekhah
101	Nailah Amandari	4	\N	nailah.amandari	$2y$12$QSnnK0QAX/cWILvZbEl5He08gYcB33T7m3jg4YV.QlweEr/ZJdME.	3886	99506982	P	Purworejo	2009-10-21	3306066110090001	Islam	RT 2/RW 2 Sidomulyo Desa/Kel. Sido Mulyo Kec. Purworejo	Sukarman	Sudaryanti
102	Nayla Ardina Pramesti	4	\N	nayla.pramesti	$2y$12$I1H6mybe/xRM13uHAGAMzeEMl5vjEMmyXBjCOtzZEOz0u8CUwFTWW	3887	94215556	P	Purworejo	2009-12-14	3306065412090001	Islam	RT 2/RW 4 Brenggong Desa/Kel. Brenggong Kec. Purworejo	Budi Riyanto	Erna Wahyu Lestari
105	Ririn Anggraeni	4	\N	ririn.anggraeni	$2y$12$nEmvMQjqydhQ27XfcXtDt.MHalsneTSEc5pjActr//zmfTqIjdIPa	3890	101780288	P	Purworejo	2010-07-07	3306064707100001	Islam	RT 1/RW 8 Desa/Kel. Tambakrejo Kec. Purworejo	Suryanto	Indartik
106	Sakina Ginta Witalestisya	4	\N	sakina.witalestisya	$2y$12$YaAv/XXthy5gmSyeq.t.d.qcaiano1c74ld6dY7daWTXQZWJbTW5e	3891	109678736	P	Purworejo	2010-01-13	3306045301100001	Islam	RT 1/RW 1 Durensari Kec. Bagelen	Agus Aryanto	Widiyati
108	Shavina Nadya Aulia Vanesha	4	\N	shavina.vanesha	$2y$12$epa9ADGVnmgZnozBvnQCWO1Q.K9ZP421zRbijClrayw4syf8NTZLm	3893	98760729	P	Purworejo	2009-10-24	3306046410090001	Islam	RT 1/RW 4 Ngargo Desa/Kel. Hargorojo Kec. Bagelen	Supriyono	Astutik
111	Ulfa Erviana	4	\N	ulfa.erviana	$2y$12$VVVz4eg0mE356.dP/K8gw.ooy4npmfKGGLwgX4g7p/HOKOsGk7LoW	3896	92382379	P	Purworejo	2009-11-23	3306066311090001	Islam	RT 1/RW 1 Jambul Desa/Kel. Brenggong Kec. Purworejo	Edy Nugroho	Ponisah
113	Zaskia Oktavianti	4	\N	zaskia.oktavianti	$2y$12$YpPCdtyJ61AMPU70SYxKI.lqYTI98CJ4wDSLip5CncMhgDACupuN2	3898	94366116	P	Purworejo	2009-10-21	3306036110090001	Islam	RT 2/RW 5 Ngandul Rt 002 Rw 005, Jenarwetan, Purwodadi Jenar Wetan Kec. Purwodadi	Waludin	Feni Widiyanti
116	Alya Diva Indhira	5	\N	alya.indhira	$2y$12$L6ifBQg0t/xe.EVAkaDIs.czug7wgRgW0vdXzNIuU5lDgkVP19aki	3901	95955067	P	Purworejo	2009-11-04	3306124411090001	Islam	RT 3/RW 2 Loning Ngasem Desa/Kel. Loning Kec. Kemiri	Uji Luhur Pribadi	Agus Setyowati
117	Anis Fiki Fitria Ramdhani	5	\N	anis.ramdhani	$2y$12$Cl5ETbKEwW2yDTT1XcpXaeduJK13QnRasX1PUi3E9we.lye8ympQa	3902	102457473	P	Purworejo	2010-08-20	3306046008100002	Islam	RT 1/RW 4 Semagung Wetan Semagung Kec. Bagelen	Berkah	Sri Asih
120	Bekti Ariani	5	\N	bekti.ariani	$2y$12$gh6C3qN70egU/S5ZWxCDqe9NWsB76tesEC9i8hSnd6H2hnjxSFGDG	3905	101318692	P	Purworejo	2010-06-26	3306066606100003	Islam	RT 4/RW 1 Jombangan Desa/Kel. Ganggeng Kec. Purworejo	Wahyudi	Tri Utami
121	Della Revania	5	\N	della.revania	$2y$12$kFXNJOT7PqkXItPEA6v0ZuqB.n9WT4C7MrrmAgAxWd2U7031snihe	3906	109397987	P	Purworejo	2010-05-05	3306054505100002	Islam	RT 1/RW 4 Sijanur Desa/Kel. Somongari Kec. Kaligesing	Ngadiman	Pawiti
123	Dina Nugrahaeni	5	\N	dina.nugrahaeni	$2y$12$fTDXga6PLdScNY2uNd7oS.P8d1ZWrG1wXN5kTB6qPJp8jw1Fx8qte	3908	101387317	P	Purworejo	2010-01-20	3306076001100001	Islam	RT 3/RW 3 Borokidul Boro Wetan Kec. Banyu Urip	Puji Indratmoko	Endang Pujirahayu
126	Diva Yulian Nurhalimah	5	\N	diva.nurhalimah	$2y$12$1o/95Y5lLmQc/tmbAHBw4eM54vIWRUv4OjFmT11.N5aBaSBJNgRaS	3911	106205310	P	Purworejo	2010-07-27	3306046707100001	Islam	RT 1/RW 5 Tepus Rt 001 Rw 005, Somorejo, Bagelen, Purworejo Somorejo Kec. Bagelen	Sarlan	Satilah
127	Duta Handayani	5	\N	duta.handayani	$2y$12$Nza6plUfF3s7xFPyNZcovudNG20FpTFwTtnqOflPVWbA4Q5OxZdhO	3912	98806566	P	Purworejo	2009-04-16	3306045604090001	Islam	RT 5/RW 3 Ketitang Rt 005 Rw 003 Sokoagung Bagelen Desa/Kel. Sokoagung Kec. Bagelen	Narko	Budiyanti
130	Eri Nurmala	5	\N	eri.nurmala	$2y$12$jod.MFj8ys7wf9R.q3iSLuDnVYfvoiIx.I.ajYhlJonmr.aw2azv6	3915	96767637	P	Purworejo	2009-11-12	3306045211090003	Islam	RT 1/RW 1 Durensari Kec. Bagelen	Sarno Hartoyo	Tusiyam
131	Ika Amelia Rahma Dani	5	\N	ika.dani	$2y$12$ZDp3Ws7g7OhsYI8PnJF9vO8TxhTn4wdoTrKsolJ/8bsgLmNrnlGJW	3916	93931324	P	Purworejo	2009-08-29	3306056908090001	Islam	RT 3/RW 1 Krajan Somongari Kec. Kaligesing	Supriyanto	Suliyah
133	Meylani Dwi Aulia	5	\N	meylani.aulia	$2y$12$j2GqRzpYyJ2Y5.Rsb03b1ua6Ba5hvp4aWy33c.KyuW7pmXKZG8orS	3918		P	Purworejo	2010-05-22		Islam	RT 01/ RW 002 Tlogoburu, Kec. Kaligesing Kab. Purworejo	Muryono	Sukitri
136	Mufidatus Solihah	5	\N	mufidatus.solihah	$2y$12$biC5nB1qKw0WsT0FQxyK6OgSZ2V/gDRQgfFmaViIjC4CNQ5UuEZWO	3921	109148244	P	Purworejo	2010-08-15	3306055508100003	Islam	RT 2/RW 3 Sudorogo Sudorogo Kec. Kaligesing	Asrori	Sulestari
137	Nabila	5	\N	nabila	$2y$12$.03zZZDJcnj6tOtU6r4J1ucU34NSunAHFfGjFjjCiVM3BjusFehD6	3922	98084603	P	Purworejo	2009-12-23	3306046312090001	Islam	RT 5/RW 1 Durensari Kec. Bagelen	Surini	Surini
140	Nisa Salsabila	5	\N	nisa.salsabila	$2y$12$GA3LL6igBVTDh2JvqJOk5Od1OfwKyO6xq/9QKFYldvju4QfuYumtO	3925	97525332	P	Purworejo	2009-12-04	3306044412090001	Islam	RT 2/RW 5 Setoyo Hargorojo Kec. Bagelen	Ngadirun	Suparti
141	Nur Chaliimah	5	\N	nur.chaliimah	$2y$12$5apQW8HSR9yZ9XXfNuIgfeU4iOY8h.TkR2pX8L7PskET5dnI7aXD2	3926	105701703	P	Purworejo	2010-03-01	3306054103100005	Islam	RT 2/RW 1 Krajan Ngaran Kec. Kaligesing	Muhamad Makruf	Wasilah
144	Sava Nala Claresta	5	\N	sava.claresta	$2y$12$ZyQu2UhB1zpovcTKtQXeRusEuaTqTHJScTbsH3T8sn9HHjpPICe7u	3929	108246966	P	Purworejo	2010-01-07	3306064701100001	Islam	RT 2/RW 2 Jogoresan Desa/Kel. Ganggeng Kec. Purworejo	Sarwo Edi	Nunung Trihisti
146	Shofiya Rahma	5	\N	shofiya.rahma	$2y$12$f60AEFpbaED0SS4hgy6Kue.BIAKjsJr4ocpZULXvRFW6da0cBGEDS	3931	92543803	P	Purworejo	2009-08-11	3306155108090001	Islam	RT 1/RW 7 Sikembang Kalinongko Kec. Loano	Jamil	Legiwati
147	Sofi Aulia Zahra	5	\N	sofi.zahra	$2y$12$DT/eAiuQz4hILRVlGtCcDeGsw8sqTuK4IlspIL6PFRl/3p.KS7iTG	3932	3090118240	P	Purworejo	2009-06-05	3306064506090002	Islam	RT 0/RW 0 - - Kec. Purworejo		Anni Rachmawati
150	Umi Amanah	5	\N	umi.amanah	$2y$12$G8UZRojfsAS05SvYpdLH.e7kjH4bAs3AGWjpymeLBCC9AhEUy8cO2	3935	105315534	P	Purworejo	2010-06-01	3306054106100003	Islam	RT 5/RW 3 Sawahan Desa/Kel. Somongari Kec. Kaligesing	Margono	Binarti
9	Amelia Altha Funnisa	6	\N	amelia.funnisa	$2y$12$x2Q9k6thpzgNJlaKPezooeOX3dbIbNnO8RD6YUZTI6gAT8IkTMqR2	3937	101875733	P	Bogor	2010-01-01	3201054101100001	Islam	RT 0/RW 0 Desa/Kel. Tonjong Kec. Tajurhalang	Suyanto	Sunartinah
11	Anisya Suci Febiyani	6	\N	anisya.febiyani	$2y$12$VsGQzlDsu4VS.SdqvR2lMu5eAOD05klAs385BtFjjZk.5fyQKYDMm	3939	3109710644	P	Jayapura	2010-02-05	9103014502100003	Islam	RT /RW Mekar Sari Mekar Sari Kec. Warkuk Ranau Selatan		Siti Dewi Ningsih
13	Aulya Cahya Putri	6	\N	aulya.putri	$2y$12$orvZkt3JRaPlBCpfmfoevutNA.Q29MX3VHjM6zfLWP3E5DDx8EzR6	3941	91769507	P	Purworejo	2009-11-11	3306045111090001	Islam	RT 1/RW 2 Kuwojo Rt 001 Rw 002, Dadirejo, Bagelen Dadirejo Kec. Bagelen	Subardiyono	Ronjiyah
15	Darin Khairunnisa	6	\N	darin.khairunnisa	$2y$12$tlURc3cVBFqn7KBWQPv17OW8alHrqaqp3DGxUCm2GJ3/UYQtWBWwG	3943	92985289	P	Bogor	2009-12-05	3306040512090002	Islam	RT 1/RW 2 Sikuning Hargorojo Kec. Bagelen	Muhtar	Wahyu Melati Pertiwi
40	Siti Nur Hidayat	6	\N	siti.hidayat	$2y$12$Tx/5f/Jt0y70CiucjdzBEexONXr5NUhbkjBwhhyfXgpjNFeB650IO	3968	96583445	P	Purworejo	2009-11-06	3306054611090001	Islam	RT 3/RW 4 Munggangrejo Desa/Kel. Hulosobo Kec. Kaligesing	Supari	Wafiroh
44	Aleta Veli Yuanda	7	\N	aleta.yuanda	$2y$12$KaM4e7bBCHp/YsNsXlvelu0gmVT9vQrc8M6wlgK7/DsMuJL5I8DHa	3972	108160414	P	Purworejo	2010-03-15	3306055503100002	Islam	RT 2/RW 1 Jarakan Desa/Kel. Purbowono Kec. Kaligesing	Dwi Chandra	Wahyu Suciati
45	Alfi Nurohma	7	\N	alfi.nurohma	$2y$12$q7A8JRjMwkwB48lQizSjNu83xW5v84ZGWHCCJ8An8ZBUNRCarSFF6	3973	101136894	P	Purworejo	2010-08-06	3306054608100001	Islam	RT 6/RW 2 Krajan Sikajut Desa/Kel. Jatirejo Kec. Kaligesing	Harsono	Winarti
47	Ammar Rizky Putra Febrian	7	\N	ammar.febrian	$2y$12$XeTUjkgb8dmUb2qBjKNP4ezV1EIe9XJqHOtV6.9gbtte1ssPc05Hu	3975	106630302	L	Purworejo	2010-02-14	3306061402100001	Islam	RT 1/RW 1 Desa Kidul Pacekelan Kec. Purworejo	Didik Fery Kristianto	Tutik Widayati
49	Anita Nur Azizah	7	\N	anita.azizah	$2y$12$LsisME/TPkhxgApm3H75sexfupcj8PAuQAum3C2Cki8T4PGljYyB.	3977	109065519	P	Purworejo	2010-03-31	3306047103100001	Islam	RT 2/RW 2 Kenteng Rt 002 Rw 002 Somorejo Bagelen Desa/Kel. Somorejo Kec. Bagelen	Budi Santoso	Agus Suratini
51	Ayu Rohmah Setyasih	7	\N	ayu.setyasih	$2y$12$e0KRpk3WmZqMCtCk517hFOTryGx2Y.oi7wx3yvA8WPXpItZVyZSrW	3979	104919424	P	Purworejo	2010-05-23	3306056305100001	Islam	RT 3/RW 7 Wonorejo Desa/Kel. Kaligono Kec. Kaligesing	Alim Budi Hartono	Sri Lasmini
54	Choirunnisa Az'Zahra	7	\N	choirunnisa.azzahra	$2y$12$zqmNVssaUcxnmaGtJIPXSesm0lY3reqgopQz4wDgiGek5cPMBmsCe	3982	99096578	P	Purworejo	2009-09-09	3306084909090002	Islam	RT 1/RW 5 Sambeng Bambon Kec. Bayan	Endrawan Bagus Pradono	Puriyantiningsih
55	Citra Pratama Ayu Mutia	7	\N	citra.mutia	$2y$12$DL5YGqXevP2bKiugcVFck.IzoQz1T9tYxI2FSfmXvPNDHFPIxql1O	3983	109194135	P	Purworejo	2010-06-22	3306066206100002	Islam	RT 2/RW 6 Kenyaen I Desa/Kel. Semawung Kec. Purworejo		Nuri Apriyani
58	Dinda Mardiani	7	\N	dinda.mardiani	$2y$12$nlmNkzXVzFjFMH3RbDk9JeeCvrxBut4BllWNethmOAEGHv4o4TZaK	3986	104088711	P	Purworejo	2010-04-18	3306045804100002	Islam	RT 8/RW 1 Keposong Rt 008 Rw 001 Kalirejo Bagelen Desa/Kel. Kalirejo Kec. Bagelen	Parjiman	Partini
59	Erlina Eka Pravitasari	7	\N	erlina.pravitasari	$2y$12$IcaYJ5O1QUKO.psTT08B3.1rOrwJplbKFaXWzITj5EIUq5uBCjXAS	3987	93226412	P	Purworejo	2009-11-03	3306044311090001	Islam	RT 4/RW 1 Krajan Semono Kec. Bagelen	Sugeng Prasetyo	Eli Kurniawati
61	Lea Azuna Sholeha	7	\N	lea.sholeha	$2y$12$KMCxThu7ijpEq8T9TbxmyuwfHn4hTCXYr441PFJ7ihf9cEoiYIjta	3989	93666660	P	Purworejo	2009-08-13	3306075308090002	Islam	RT 1/RW 2 Boro Wetan Kec. Banyu Urip	Wahyu Susanto	Yuli Ernawati
64	Najwa Putri Fadhillah	7	\N	najwa.fadhillah	$2y$12$ymr5R9L.9dKsVZJaNRx8sO9smlM/8fM5TX5x8SNo72mhofCbmIGCe	3992	93327666	P	Purworejo	2009-06-21	3306046106090001	Islam	RT 1/RW 4 Sijanur Desa/Kel. Somongari Kec. Kaligesing	Susilo Winanto	Ekawati
65	Najwa Salsabila Chakim	7	\N	najwa.chakim	$2y$12$j7Djg3cFz13clr5cS7pUZuWvdKCxuMHFIP6xwSfWtj0I0cZyfBPvO	3993	106090942	P	Purworejo	2010-03-07	3306034703100002	Islam	RT 1/RW 5 Ngandul Jenarwetan Kec. Purwodadi	Lukman Chakim	Wartiningsih
68	Rima Dwi Astuti	7	\N	rima.astuti	$2y$12$pn3nEAUuRyaS16x9DC39k.EW7LeGQ0yMU875PWs5D2Hl5ut6.Bcem	3996	91491569	P	Purworejo	2009-10-10	3306065010090002	Islam	RT 1/RW 5 Desa/Kel. Sido Mulyo Kec. Purworejo	Misroni	Sutinah
70	Saras Ratnawati	7	\N	saras.ratnawati	$2y$12$nFU/egH1Eoo1HHNRdCDsTOobK6P5KEdJilLoeCffOcoar9ffg8ktu	3998	102401469	P	Purworejo	2010-03-20	3306046003100002	Islam	RT 4/RW 3 Kibon Desa/Kel. Piji Kec. Bagelen	Isman	Maryuni
71	Septi Rahayu	7	\N	septi.rahayu	$2y$12$W4xHf647oWEwQ.c4VtTfLeNb/w3lRfBifI41tBLwoGcf6HUr.F0By	3999	91923168	P	Purworejo	2009-09-12	3306045209090002	Islam	RT 3/RW 2 Sikuning Rt 003 Rw 002, Hargorojo, Bagelen Desa/Kel. Hargorojo Kec. Bagelen	Tusiman	Ngatini
74	Suci Aulyafitri	7	\N	suci.aulyafitri	$2y$12$jhLgz.oqdIDrAPi3sDViR.oK4VNLrYmrAnEzI0fiLYOP33Junp7Xq	4002	99240705	P	Pekanbaru	2009-09-28	1471106809090002	Islam	RT 2/RW 1 Plarangan Desa/Kel. Hargorojo Kec. Bagelen	Azhari	Nurhalmi
75	Trianda Iza Saida	7	\N	trianda.saida	$2y$12$wpUJQkrDE4Q9FCwXsNnNZOJl2iSTmnV9QlwlfDn2D8Y38yAqPUqYa	4003	96336580	P	Purworejo	2009-12-24	3306056412090001	Islam	RT 1/RW 3 Sewu Desa/Kel. Kedunggubah Kec. Kaligesing	Said	Sariyem
78	Zullia Dwi Relita	7	\N	zullia.relita	$2y$12$huVpWW2e5IIXBkn6ODJwMu16fGw6whDvtUOZAGZf353EtwezkwXfO	4006	101371896	P	Purworejo	2010-07-21	3306056107100003	Islam	RT 5/RW 2 Krajan Desa/Kel. Jatirejo Kec. Kaligesing	Uji Karyanto	Sari Hatiningsih
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, username, password, fullname, "position", photo_url, nip, pangkat, jabatan, is_wali, password_piket) FROM stdin;
3	Agustina	$2y$12$yup3I1Md162sH7hf6wXMfucXgkF6Cz0TxFR6NePCXgQZPNJJJUNri	Agustina Rusdi Prihandani, S.Pd	Guru BK	\N	199404112024212018	\N	\N	t	$2y$12$4A8NRIC6a2J/bz3XpWRtru1U6t72M6AsR.zCwGaNYpzVzyf8HU5pO
4	Ahmad	$2y$12$FvvJg6oRouMbq2w6WGoX5e6jx5ars7U25XNMMUN.wmZndikM4hun.	Ahmad Zumaro, S.Pd	Guru Agama Islam	https://drive.google.com/uc?export=download&id=1HdU7zuNnGgM-a5yg0Mu5devZEUoW2HNf/view?usp=drivesdk	\N	\N	\N	f	$2y$12$o/Cp2bbz9LwIVB/l0wn2iein0Vm4nTMdsOJhfcIcrKqXUnYS8o55.
98	Ambar	$2y$12$aTrnngLcIgOdv0ObggqYmuu5onr2ZNNRc3WJAXFUg.6.1ln4WJOni	Ambarini Widjaya, S.Pd	Guru BK	\N	199506042025212062\n	\N	\N	f	$2y$12$ugIYfkl/FwMWiMASAV.hhOwvL9X8v80x2toSEb5a41O3oTFFAfEFO
6	Daim	$2y$12$3PuVRguZidCbKb1IFBaBB.L4e37rQ1uq1Db6JcaOtGdhvBTFFDsOS	Daimurahman, S.H.I.	Guru PKn	https://drive.google.com/uc?export=download&id=1mwALY5EX4ncjgb9-wHUS0htixaYQPITd/view?usp=drivesdk	199203102023211010	\N	\N	t	$2y$12$wKZmx5fZ53B.RR/cl5U.DO5KV.M1lSDGNHAU4zXD6PiVmoCWy2Hzq
7	Wirasti	$2y$12$xCXVLZsWhXGY1iZ6X1kkDeHbxdpaITdrkdbu87LKTmPAeNJoQl7Y6	Dra. Wirasti Ima S	Guru Busana	https://drive.google.com/file/d/1VszYXJd63IsnI25-EBjPhV5UT79ikUY-/view?usp=drivesdk	196809192023212001	\N	\N	t	$2y$12$98hR8jMKv2zYU2db9Pb4V.SoiWzn1d7dheuttM1fMsGTN5eCw39ki
8	Drajat	$2y$12$TD.rtoiEfpoNTJ39YksUz.PsQc8.XfbmHZwlvxrEFF9ObxcBrCuBG	Drajat Hariswanto, S.T.	Kakonli Listrik	https://drive.google.com/file/d/181dHusUjZMAKLCppKWO2eKcHx5cWg32F/view?usp=drivesdk	197309062006041003	\N	\N	t	$2y$12$XIBQ1U3EUkJYSofQRHBOhuHmg4O2QDSuhR9VXQ6J3PrqZzjNg2Y2q
9	Suharno	$2y$12$bgBddySUTg/klbRtaV2WbO2DPmQc1CaMYLAHENXdRB6XlUuCCPnPm	Drs. Suharno	Guru Matematika	https://drive.google.com/file/d/1jc3xnBQCy0FdjY_-CAKdiuOyaD7BVTar/view?usp=drivesdk	\N	\N	\N	f	$2y$12$tb/UfutNAgOj0DwrDrx5sOC3zIf1BPAFSoVJSOvzYfd3lSD69kVZa
12	Eko	$2y$12$CfwMIVyfGdios3.i0vCoaueaYYEYpWhP5h5.blZPAONjqI/enV2me	Eko Budi Fatwa, S.Pd	Guru Akuntansi	https://drive.google.com/uc?export=download&id=1Qm8sV8G25qArtaYUq8dl1pdlDWYgdFyC/view?usp=drivesdk	197508262023211001	\N	\N	t	$2y$12$UqcHgWkgRSKz7H4K9.gQrO6/inCXJblJsVX/DoEyO4W8Pdo/XeaM2
94	Sudar	$2y$12$qMuf2Q7Du1ngU4tWz3pHyeLaWh9GqSrLRmXPWjCx7o9A4snmGp7v.	Sudarsono	Tata Usaha	https://drive.google.com/file/d/1wVVicTBTpDeELOVeb096kpFqEvEPLZ6u/view?usp=drivesdk	\N	\N	\N	f	$2y$12$Is/lckFZenGqEGon6nLCguLAngs4qsuq2snRNf/hKsgEU/BsPaCkW
95	Fajar	$2y$12$HlUYHG2T1TElmVT9e9p4zuMZM1tqFEcojk9lSBKyte1VyK/lytf1a	Fajar Karyanto, S.Pd.	Guru	\N	198009292010011012	\N	\N	f	$2y$12$9PFT.JfACfen4H.XG1GPYuby8syWO5hzNnvI39mXgTF17snHBrfCW
97	Anita	$2y$12$7JYnhBBETOo7XAurzZYzpuPt5j/pupduTIjxj8KX2EZCUTV8HWT6a	Anita Kusumadewi, S.Pd.	Guru Akuntansi	\N	198801192025212051	\N	\N	f	$2y$12$ZYMLdWDCQYtUHXbohHqqXuQvqNJWQZ3DD2RkiqsiYAX5P/NV5NwOa
99	\N	$2y$12$NB9JkTOFW14.1hmbLFRso.fnF4nHg2reoOATS7cYq1lEbBX.gEGSe	\N		\N	\N	\N	\N	f	\N
2	Afiana	$2y$12$vdzrVGCu7tUcLiGdW.cLN.fUDMHZFu5RN.eE3YSuHVT5/kX59E.4m	Afiana Kumala Tsani, S.Pd.	Guru BK	https://drive.google.com/file/d/1m1Wzn7I8VxXe0vAahwFfCqTedwLSR5qf/view?usp=sharing	198610052020122006	\N	\N	t	$2y$12$T76AhL6L6za/nW3qGMc/bONiK4XMvjShOiY.My.le3sgteQV7vzAy
5	Ardi	$2y$12$nvR9JJlADe1miay6B3CNP.GVXGuVSFYPg/gWjMYwoMm/YvYc.OaOO	Ardi Setiyono, S.Pd.	Guru Olah Raga	https://drive.google.com/file/d/1QOiSUIFOGkMm6lb1zo_QO0T1vGE2k98q/view?usp=drivesdk	197005012007011015	\N	\N	t	$2y$12$6L3dhv8MmyZfVRpwxuATe.duybyoKB/Di4VCeir8NNkOnItHQYys.
10	Dwi	$2y$12$ODXqBPTyopMTODWn0UgQjOJaaj3nOzZVUedMwOVASlOKFceqzderi	Dwi Aryanto, S.T.	Guru Informatika	https://drive.google.com/uc?export=download&id=1t_YNuBdUbML2J9Itsm5eDbmqRtQq52v_/view?usp=drivesdk	198612022022211004	\N	\N	t	$2y$12$1/tzBu47DxNaRHIU3QisAe4Co6RQaWZU8L3bz0BDJEGd/GR6hX.6i
14	Sutriyana	$2y$12$PXFPrho2tAY7AK4lhXc5B.yOUlESCQ/Uu7hnSG0vcQemW3NtEv4lO	Ign. Sutriyana, S.Pd.	Guru Listrik	https://drive.google.com/file/d/1EcGcUj5rZ_NkuBYUezIEaLX8-YAIuKVG/view?usp=drivesdk	196802262005011003	\N	\N	t	$2y$12$c6GOOFFWOAgBs7CCbWTwg.FGNFLHH0GQHTX4H/w.Ml6O8XX3GRV.W
19	Ngatiyah	$2y$12$q7EEwyOQm4l4nsyiYP68q.YDP6CNRHJP1yCH/r7z/sdzaVRz/hLre	Ngatiyah, S.Pd	Guru Bahasa Inggris	https://drive.google.com/file/d/12rikK06Kiff5LdYwxcuO58yGRb909rlg/view?usp=drivesdk	197005302007012007	\N	\N	t	$2y$12$dYWUn/rNuiJa8EFkjX6pV.qbTm9eztH0YCC3lwHXpN5G35MoYoBAm
24	David	$2y$12$svnne8dVaIccqczLIwhCluXsMrgaWTAyzop7iHBkM12Oyau3QnVua	R.David Purba Irawan,S.Pd	Guru Bahasa Indonesia	https://drive.google.com/uc?export=download&id=1t7rogzEY1txWCCokKAbGeX2V7vpidkSe/view?usp=drivesdk	198909092019021004	\N	\N	t	$2y$12$uKygboDTtaflVjRQKc2xUuG9jfGeg4r9rWO1TXeGTn6mkbQexakDq
29	Riyani	$2y$12$pTGThcAPXfyGwczZcIGkcudhLYqXI.AeCUA/52YmxsJ85gFQFHTHK	Riyani, S.Pd., M.Pd	Guru Bahasa Indonesia	https://drive.google.com/uc?export=download&id=1t6S_CgoGNCMSIlTOD8q-og5B9uuNWBYL/view?usp=drivesdk	198506282019022005	\N	\N	t	$2y$12$9DdvkWSmBfeSPJETWihYz.4trgKbHdiGzDBNnsq14pev6nRanYorG
34	Lestari	$2y$12$Wy/O2P/iRA7uliCprOht7OVj8bTzKkgWZfdKRg6Hdaaf1bazy55uu	Sri Lestari, S.Pd.	Guru Busana	https://drive.google.com/file/d/1j9wpOCmUZJYaLbXCMPxb-svy2qdSO3gv/view?usp=drivesdk	197304132023212002	\N	\N	t	$2y$12$2cH47pILSKPz6U1n98zmreRZtolulabxpeU32nenYddgG9Tx1KIXy
38	Wuri	$2y$12$MQd4RETvI11ZvrKJvilS/ehwme5zvB9CTYL7fVhti/DeB9caiDuQS	Wuri Andriyani, S.Pd.	Guru Akuntansi	https://drive.google.com/uc?export=download&id=1ZHrwkSVn9c_H95sY6_yXnqJcjfw8ALFN/view?usp=drivesdk	198906122022212019	\N	\N	t	$2y$12$FmG4rluz3ojmsbayncnH5OAuQ.f1mZupITTmpxOnGRYTrj9cbwD2e
40	Yulia	$2y$12$mFjZiyD//0foFvfQSLnStu1TVBTJ81kkwYsktLfOO2sz4RIMmtOh2	Yulia Paksi W, S.Pd	Guru Seni udaya	https://drive.google.com/uc?export=download&id=18fiUyglZPAyiiu0aJJwYflFYeO7OfW5V	199507072022211001	\N	\N	t	$2y$12$MmKpQK1Ln1dvHC3B.pab1.p.ayqHlGZeuvc3mb/tfeFvIKhw2DOT.
13	Fadjar	$2y$12$bDBpOIZaw1jSZiipz7tpiOhW6KyVndyprcvbwIMDQG.NcjKBukhkS	Fadjar Ari Triwibowo, S.E.	Guru Akuntansi	https://drive.google.com/uc?export=download&id=1Ne-jcEQclXxtUuDwjKRzjWKB3EbxJmjv/view?usp=drivesdk	197001072023211001	\N	\N	t	$2y$12$aSxd1iMjKms1BJXiJnE1ou0uWzpIRAmPH18qem/hwjDXnHXST1lX2
15	Isni	$2y$12$QTgQ5Ac.UBj1.5OkmBmMWOw5ig.TAWB4uFeXPTWmQ43Pe7ZCr9Dda	Isni Pawening, S.Pd.	Guru Informatika	https://drive.google.com/uc?export=download&id=1FfANsZe4slRU0S3oQpkY9og1sR9QwR7x/view?usp=drivesdk	199207072022212010	\N	\N	t	$2y$12$056VUwXmPtfghsRpdfViluc/HbZEe2HtZsh611dU6u/6FbehgjnHe
16	Khadir	$2y$12$29zXJWi6KFYXpAs.l6thnuLrPtfA2nHx6WCclET1CSR6jdHxRFrlS	Khadiratul Khotimah, S.Pd.	Guru IPAS	https://drive.google.com/uc?export=download&id=1Zh7uujrmUFVYTcgotzPp4enHKcjD9aYR/view?usp=drivesdk	199010252022212016	\N	\N	t	$2y$12$NEi3Yb50OKJ8IUxACtiYt.8g.j2KBilEcCbNm/SG3xOIDzCoArZDa
17	Mardi	$2y$12$.gTSgaEOeFuTOrYlMyPBNOm9dP5FJdYs8WvGrfl6vMgUSRBioaclO	Mardi Utomo, M.Si	Guru Agama Islam	https://drive.google.com/uc?export=download&id=1OV7_eFNolXwN7vE0pHdhu0E31yDe29Q5/view?usp=drivesdk	\N	\N	\N	f	$2y$12$K2K3YC3giDKzh3j2kJ8lxObLO041zimolBoDalz/p0p106ZZet7JC
21	Nurhas	$2y$12$ahvfEBs.7ZsV3AcRFlE2I.7OwQpPUxAzgl/jcQ4d9fw05sHbmPwF.	Nurhastuti Putri Utami, S.Pd	Guru Busana	https://drive.google.com/file/d/1LcJ1wNel_XHS5XaMi_E-U4yxrAcBLoRA/view?usp=drivesdk	\N	\N	\N	t	$2y$12$oQpzCGKPFyv94Aju6wDyme02C5S73ZgPwv3mcByHuZK0csYkLYsNu
27	Wulan	$2y$12$so3bUR50S4J0aG/O4B4cAOAMBv8xFxjUfREQ70ssEhe1hQyb/dnLe	Retno Wulandari, S.Pd.	Guru Akuntansi	https://drive.google.com/uc?export=download&id=1oYzsg3XVGfschZE6S0d6fyuxIhoTUELL/view?usp=drivesdk	198603152022212062	\N	\N	t	$2y$12$EEa3SrZuG8qF6GCHb40PauBKxfyx/n7ih.1bxM0JRyRO.gGC//M1C
28	Rina	$2y$12$MUkbq.1d8ytTmyBj6vCVouOuKIcPjQc/gCaL3jUCpNditOtLtAz/e	Rina Istiyani, S.Pd., M.Pd	Guru Busana	https://drive.google.com/file/d/1ymrUjM4EUjoGVxFYsHs5Fh7kQ8FXCbD2/view?usp=drivesdk	197412042005012003	\N	\N	t	$2y$12$2LS5FEUKIJseJqPbb07N7OLz9hZzSdUFR7y4T3Rn8aue7ufSrGoH6
36	Subagiyo	$2y$12$qXXxISMTw9gLVtqizAHTT.ePaFt0ag.U86lbvqczJhhiTxIqMg9bO	Subagiyo, S.Pd.	Waka Listrik	https://drive.google.com/uc?export=download&id=1IQGJz5UZOEHoozsDzDjGbbVldWfztgd_/view?usp=drivesdk	197001012021211006	\N	\N	t	$2y$12$5SrKJBP.q.ZJm0Ph/dtKuu6gK.K/VWXJNQ/taHEloMaxm2XloUEtK
35	Suwarni	$2y$12$U4ZZBpkiDmR8PnnnLQhtQuhiRJS/A9wUhRYIWPFamEPllAQxioeVe	Sri Suwarni, S.Pd.	Guru Busana	https://drive.google.com/file/d/1HoYmzaZ916guHHSH1OC2wly9KH9Q2B-M/view?usp=drivesdk	198002162022212010	\N	\N	t	$2y$12$BqtIXdK6JD94p4q/RCU4wOjvcuT6ny/RQbGHC0Lk7p9QnGsuPHC.K
11	Edar	$2y$12$/dGe7knnA3gpxzcLb3HKNeyN2iXzPz9G.Pc2OyIVS.YZTC2/Vx2Ti	Edi Dwi Agus Rijanto, S.Pd.	Guru Listrik	https://drive.google.com/file/d/1Bt-ZkkC-YpVNrNb9_kc03Yae21yrwBkm/view?usp=sharing	197012152007011012	Penata Tk. I/III d	Guru Muda	t	$2y$12$u8fpajcPDW2KWC3TF2SlNOJ1fxEFQIV7jhEpHkJ/gxMOYgrSD0me6
32	Slamet	$2y$12$xHD2KUracxFwU9yKTEPbI.rxCfmfejmwhV4ApB4TgfrDpG0NYS5.y	Slamet, S.Pd	Guru Pendidikan Pancasila	https://drive.google.com/file/d/1VvuALd25XyPsbnqoUj4M3x-wZ6YmHXce/view?usp=drivesdk	196603281998021002	\N	\N	t	$2y$12$AMriNeGbqi.KCD8PJobQ4.hVdGkOaHa1lJGvv3xGMwMZq6iLKCgpS
1	Nuryati	$2y$12$m0e5nhwO37yIMgUPQ/pKMucrLJg9Mrl/EOhx8r1aQYR07TIvgFp2W	Dra. Nuryati, M.Pd.	Administrator	\N	196812101995122005	\N	\N	\N	$2y$12$xtNlP2T5pJPvW5G07bqfR.n4ELFCIDmqcdUtm3j/Lta/dZ8LWJXwC
18	Nanik	$2y$12$rSflavRREgAFUe3Nsx/eKuREdxtuFpCOdGVUItiNuIUJ1jdBBk8wO	Nanik Iramawati, S.Pd.	Guru Bahasa Inggris	https://drive.google.com/file/d/1fDUejMBVD6rhIE3PYopeOezqXGb_hi0c/view?usp=drivesdk	197103312006042008	\N	\N	t	$2y$12$HzVNZoD6es8sBojCgDgQpO7K/SxW6kG0Xf/AKIKfx.5vksbtLQrxW
20	Nur	$2y$12$2MvO7IQIP5PZSk8BKIX9OOveBkVij.IDlDkBVivF3VXvF3g9fRcUW	Nur Hasanah, S.Pd	Guru Bahasa Indonesia	https://drive.google.com/file/d/1bro9mfCm8OdKRBF8HCUKcx8VyJx-rCUz/view?usp=drivesdk	197512292023212002	\N	\N	t	$2y$12$ZKlcGQzlmrnrvi9ChujKyeIq5JEAXxdK3pzYKY6INobrVAmUA0STy
22	Pandu	$2y$12$qVxy1g6k91bpUFOEm.GGCe2V1IIGwiTqg/.vRK/.DzWS03.ptOiAe	Pandu Abdul Fattah, S.Pd.	Guru IPAS	https://drive.google.com/uc?export=download&id=1y_4bZEvaJRmF7x1yJufBH_4qPLiWFIXF/view?usp=drivesdk	199007302022211007	\N	\N	t	$2y$12$XeOQoFv9YMrDJIyxQxMeGuvF4KJ/JGbrS3JY2MXYjU3xlIVo8w1da
23	Praja	$2y$12$DcE/60Erxi40h/kmCa6ojOsTocpzoo6YYeRBFgS9ef2ihK/3uJ0BO	Praja Adiguna, M.Pd.	Guru Informatika	https://drive.google.com/file/d/10cVGUCceheQA9ZQaLFEhexOvB0y7kKfK/view?usp=drivesdk	199106112022211009	\N	\N	t	$2y$12$DjHSGR4fU/c1KlcknRvc3edPS40PbetMD3W78xgSlYrBpfngE3pKO
25	Rasista	$2y$12$q2HbNMM/tGqeTk92UAr02ey3rI4HbMFKUdUibGoMHU0WMaJVcjph6	Rasista Damayanti, S.Pd	Waka Kurikulum	https://drive.google.com/file/d/1oHeENF4PhS_OSv26eXUDIaWKvtXFUZ8_/view?usp=drivesdk	198910082022212015	\N	\N	t	$2y$12$41iPflkI5zf8ftAI8hcII.uXOi2BiMyDx/6.8qwEu2a9oAhZ0erbm
26	Retno	$2y$12$E7WCT5CULujlVl0PQ9j/ieI5cknOb8A.u.M.sI9qwioZqRWuXHQJe	Retno Kustiyah Darini, S.Pd.	Guru Matematika	https://drive.google.com/file/d/1aCjRFIv-V6lbuSEqyKL1hITrvjC9BGkd/view?usp=drivesdk	197104112003122004	\N	\N	t	$2y$12$NvzFbQB9j/U.9e5YmyBIx.JZefJzdb8HR3ExTR6E6eyf5uZZrVom.
30	Sigit	$2y$12$JMCHRzPtIkqU1Kg5P/r/YepiK.PGIRijCYuK04yVvUo7.W.5XD.xS	Sigit Wahyono, S.Pd.	Guru Listrik	https://drive.google.com/file/d/15s1PP1pSbTH4ETbeBXhiy_GKmSIzZ6PV/view?usp=drivesdk	197503222008011003	\N	\N	t	$2y$12$01ST.HJH8BhLKC.BxT.ZQui5tC1p.QLfYZ8h6irsYbcj5wro0mUEy
31	Siska	$2y$12$esg6LeOg5Rad4od3VICXnuv2GdsnycKPUvLuEfRxdetTqhIFRGFua	Siska Yuliana, S.Pd.	Guru Bahasa Jawa	https://drive.google.com/file/d/1ev8FlnTrSK0KGpghHhw3ejOmAy_3r7Na/view?usp=drivesdk	198307222010012023	\N	\N	t	$2y$12$FSfT6WoYGXPOITo1iHuHOexhgaluCU6omfxIKTSFDLszS5VkHqJ/C
33	Srikun	$2y$12$GRAWF1brtxglTl45ss4g4.zCAQ0QDL/XgYeESB0RBKykACaZlOiG2	Sri Kun Fitriani,S.Pd	Kakonli Akuntansi	https://drive.google.com/file/d/1RyhT0Mn9mXrdThDpwWrFpzueBmH2-f9_/view?usp=drivesdk	198207222022212016	\N	\N	t	$2y$12$ncwV8oXQu/1eGxe4eKe21ebFmm2eXZ00YNzIAsFf/UllpbzinjsQu
37	Tyas	$2y$12$U3oFkRx3Dep.VYzYzOz1J.ZZCB91vJ3t7BoXU18YbgNo.nl4Fgmju	Tyas Sosiawan Pramudita, S.Pd.	Guru Bahasa Inggris	https://drive.google.com/uc?export=download&id=1PUPTxp5n7r_uefLywftEPYDcoHL2xOEY/view?usp=drivesdk	198412192023211003	\N	\N	t	$2y$12$DtG7i28PUwao99.oVH07U.5efVngneJA5kNryzyr9cLLPzFyvw9C2
39	Yoga	$2y$12$eETRtKHAcHCrl37nAi8VLe/nf1kLDe4SBOIvkb2CSDf3oqXDjDf/i	Yoga Kurniawan P, S.Pd	Guru Olah Raga	https://drive.google.com/file/d/1t3s_4aYc8bs38hovoLVo4OlZq43uhbcP/view?usp=drivesdk	\N	\N	\N	f	$2y$12$xc8eSC81r8ahdld8OdXN9u0bqReAA2NjoP/ukG4rEy1dto1jX4WoS
41	Zainal	$2y$12$7k.0JU/K40BbxznDVWTgK.8lMxQLhXXSAPK9xpbLBQgNp5ZnwXbTq	Zainal Abidin, S,Pd.T.	Waka Sarpras	https://drive.google.com/file/d/1kXZZXxu1XiJKnzdr1xFWMKdaZ1Eg1qEs/view?usp=sharing/view?usp=drivesdk	197805242006041018	\N	\N	t	$2y$12$Oa0U94nHEdJi1Mx0lHLM4eGihIsBkhThYanivcRTHk87vdV2Ixy5u
42	Zuhaini	$2y$12$CdKM.TDCzo7pUVh7.eAl/O3bVBz4tP3.1nbTSpcujc/SxgC0fVdhC	Zuhaini Widarti,S.Pd.T	Kakonli Busana	https://drive.google.com/uc?export=download&id=1QzpGjpvIxmR_zCdO4K_j8t3ekKFx6hbX/view?usp=drivesdk	197704252009022006	\N	\N	t	$2y$12$2w6jvMsEEZEe0kP/WNClU.1s4o4.Imnz6nu/S5C/ThMuHooy3XzVe
43	Susri	$2y$12$agoWRhVcvjyFmLJVEA2EjOAT4aDNFUnncZlQrmbsBRhuVz2rtpxNG	Susri Wuryani, S.Pd.	Guru Bahasa Indonesia	\N	198711192024212009	\N	\N	t	$2y$12$rzlizSNN2Btu2unbVPbBh.xH/H7JdnL5.xu5x6qTlznojLxXKZa6K
44	Nurur	$2y$12$O/2/zzxFGoyoYZtaAu1BQuSLWbgVLQjfyp2ZikyUPGnjv2TQmevtG	Nurur Rachmawati, S.Pd.	Guru Matematika	\N	198005182025212007 	\N	\N	f	$2y$12$Mp2hblRRL94q.T599lq2L.J3OYrmyLDsg4FAQybI6vRBkqkwgVW72
45	Aji	$2y$12$HsbGx8UUZe4/HT/mPkdR1e8TEorv7azMPYeCCwTJ.CGiIPC.N5xfS	Aji Taufiq Pambudi, S.Pd., M.Pd.	Guru BK	\N	-	\N	\N	f	$2y$12$nLJg.UIGnJx4kr5bwqwkDeZ6wfoZjLmpDbZmlQfzBgOb5ZbWrLYUG
46	Darmanto	$2y$12$e8mLtucaLDgbAjXhrUT9UO07dtnkn2/Mg0xn48IqtZyrC97AlpoRC	Darmanto, S.Pd.	Guru Agama Kristen	\N	\N	\N	\N	f	$2y$12$GAn8zTtXVQno/TxRGadFVe8qt.dWWt4s0LLNlpctNLL89W9/Oqmxy
1001	luthfi	$2y$12$7adVkxEdowx8F1h37mUSzOFYya8/ESdjshLc9Fm7fJDmsYgWIvOKS	Luthfi Bachtiar Riyanto	Super Administrator	\N	000000	-	Super Administrator	f	\N
\.


--
-- Name: catatan_siswas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.catatan_siswas_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: izins_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.izins_id_seq', 8, true);


--
-- Name: jadwals_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jadwals_id_seq', 428, true);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: jurnal_mengajars_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jurnal_mengajars_id_seq', 41, true);


--
-- Name: jurnal_presensis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jurnal_presensis_id_seq', 5598, true);


--
-- Name: kelas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kelas_id_seq', 20, true);


--
-- Name: mapels_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.mapels_id_seq', 33, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 31, true);


--
-- Name: orangtuas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orangtuas_id_seq', 1382, true);


--
-- Name: penilaians_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.penilaians_id_seq', 1, false);


--
-- Name: presensis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.presensis_id_seq', 182538, true);


--
-- Name: qr_sessions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.qr_sessions_id_seq', 107, true);


--
-- Name: siswas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.siswas_id_seq', 709, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: catatan_siswas catatan_siswas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.catatan_siswas
    ADD CONSTRAINT catatan_siswas_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: izins izins_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.izins
    ADD CONSTRAINT izins_pkey PRIMARY KEY (id);


--
-- Name: jadwals jadwals_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwals
    ADD CONSTRAINT jadwals_pkey PRIMARY KEY (id);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: jurnal_mengajars jurnal_mengajars_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jurnal_mengajars
    ADD CONSTRAINT jurnal_mengajars_pkey PRIMARY KEY (id);


--
-- Name: jurnal_presensis jurnal_presensis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jurnal_presensis
    ADD CONSTRAINT jurnal_presensis_pkey PRIMARY KEY (id);


--
-- Name: kelas kelas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kelas
    ADD CONSTRAINT kelas_pkey PRIMARY KEY (id);


--
-- Name: mapels mapels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mapels
    ADD CONSTRAINT mapels_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: orangtuas orangtuas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orangtuas
    ADD CONSTRAINT orangtuas_pkey PRIMARY KEY (id);


--
-- Name: orangtuas orangtuas_username_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orangtuas
    ADD CONSTRAINT orangtuas_username_unique UNIQUE (username);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: penilaians penilaians_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.penilaians
    ADD CONSTRAINT penilaians_pkey PRIMARY KEY (id);


--
-- Name: presensis presensis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.presensis
    ADD CONSTRAINT presensis_pkey PRIMARY KEY (id);


--
-- Name: qr_sessions qr_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qr_sessions
    ADD CONSTRAINT qr_sessions_pkey PRIMARY KEY (id);


--
-- Name: qr_sessions qr_sessions_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qr_sessions
    ADD CONSTRAINT qr_sessions_token_unique UNIQUE (token);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: siswas siswas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.siswas
    ADD CONSTRAINT siswas_pkey PRIMARY KEY (id);


--
-- Name: siswas siswas_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.siswas
    ADD CONSTRAINT siswas_username_key UNIQUE (username);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: izins izins_siswa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.izins
    ADD CONSTRAINT izins_siswa_id_foreign FOREIGN KEY (siswa_id) REFERENCES public.siswas(id);


--
-- Name: jurnal_presensis jurnal_presensis_jurnal_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jurnal_presensis
    ADD CONSTRAINT jurnal_presensis_jurnal_id_foreign FOREIGN KEY (jurnal_id) REFERENCES public.jurnal_mengajars(id) ON DELETE CASCADE;


--
-- Name: orangtuas orangtuas_siswa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orangtuas
    ADD CONSTRAINT orangtuas_siswa_id_foreign FOREIGN KEY (siswa_id) REFERENCES public.siswas(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict J9OmeMjuHCPk5woQfZOZFgBlqUeUqneoQmBcLFxZEqtedc66fH8dPc9Zz3kM8wI

